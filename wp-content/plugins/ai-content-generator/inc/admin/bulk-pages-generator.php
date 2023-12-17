<?php

require ABSPATH . 'wp-load.php';


add_action( 'wp_ajax_sage_ai_remove_from_bulk_queue', 'sage_ai_remove_from_bulk_queue' );

add_action( 'wp_ajax_sage_ai_generate_bulk_pages_call', 'sage_ai_generate_bulk_pages_call' );



/**
 * Maybe for landing page
 *
 * @return string post url.
 */
function sage_ai_generate_bulk_pages_call() {
	$title   = $_POST['title'];
	$content = $_POST['content'];

	$status = $_POST['postStatus']; // You can set it to 'draft' if you don't want to publish immediately
	$type   = ! empty( $_POST['postType'] ) ? $_POST['postType'] : 'post'; // Change to 'page' if you want to create a new page instead

	$categories = ! empty( $_POST['postCategories'] ) ? $_POST['postCategories'] : '';

	$data = sage_ai_generate_post( $content, $title, $status, $type, $categories );
	wp_send_json_success( $data );
}

/**
 * Generate Article page.
 *
 * @param string $content   Content to be published.
 * @param string $title Title of the post.
 * @param string $status    status of post. eg draft, publish, schedule.
 * @param string $type  type of post. eg post, page, custom post type.
 * @param array  $categories depricated. insted using taxonomies.
 * @param string $post_publish_date Future date as timestamp.
 * @param array  $taxonomies taxonomies in which post to added. eg categories, tags, custom...
 * @return void
 */
function sage_ai_generate_post( $content = '', $title = '', $status, $type, $categories = array(), $post_publish_date = '', $taxonomies = array() ) {

	$author_id = get_current_user_id(); // ID of the author who will be

	$new_post = array(
		'post_title'   => $title,
		'post_content' => $content,
		'post_author'  => $author_id,
		'post_status'  => $status,
		'tax_input'    => $taxonomies,
		'post_type'    => $type,
	);

	// if publish date is in future(scheduled).
	if ( $status === 'future' ) {

		$new_post['post_date'] = date( 'Y-m-d H:i:s', $post_publish_date );

	}

	if ( ! empty( $categories ) ) {

		$new_post['post_category'] = $categories;

	}

	$post_id  = wp_insert_post( $new_post );
	$post_url = get_permalink( $post_id );

	// Post created successfully
	// Add any additional meta information or perform other actions
	// $data = array( 'postUrl' => $post_url);
	return $post_url;
}



function sage_ai_remove_from_bulk_queue() {

	if ( ! isset( $_POST['id'] ) ) {
		wp_send_json_error( 'id not set' );
	}
	$job_id = $_POST['id'];

	$queued_jobs = get_option( 'sage_ai_bulk_queue_all_jobs' );

	$completed_jobs = get_option( 'sage_ai_bulk_queue_completed_jobs' );

	if ( empty( $queued_jobs ) ) {
		wp_send_json_error( 'no jobs in queue' );
	}

	// remove from all jobs
	$updated_queue = array();
	foreach ( $queued_jobs as $index => $queued_job ) {

		if ( $queued_job['id'] !== $job_id ) {
			$updated_queue[] = $queued_job;
		}
	}

	// remove from completed.
	$updated_completed = array();
	foreach ( $completed_jobs as $index => $completed_job ) {

		if ( $completed_job['id'] !== $job_id ) {
			$updated_completed[] = $completed_job;
		}
	}

	update_option( 'sage_ai_bulk_queue_all_jobs', $updated_queue );

	$modify_queued_jobs = sage_ai_get_bulk_queue_data_with_changes();

	wp_send_json_success( $modify_queued_jobs );

	// $data = sage_ai_make_content_for_classic_editor($data);
}

add_action( 'wp_ajax_sage_ai_add_bulk_to_queue', 'sage_ai_add_bulk_to_queue' );

/**
 * Add job to queue.
 */
function sage_ai_add_bulk_to_queue() {

	$articles_data = stripslashes( $_POST['articlesDetails'] );
	$settings      = stripslashes( $_POST['settings'] );
	$queueName     = stripslashes( $_POST['name'] );
	$articles_data = json_decode( $articles_data, true );
	$settings      = json_decode( $settings, true );

	$queue_Interval = isset( $settings['queueInterval'] ) ? $settings['queueInterval'] : '';
	$queue_next_run = '';
	$job_status     = 'scheduled';

	if ( ! empty( $queue_Interval ) ) {
		$queue_next_run = new DateTime();
		$queue_next_run = $queue_next_run->getTimestamp();
	}

	if ( ! empty( $queue_next_run ) && ! empty( $queue_Interval ) ) {
		$settings['queueNextRun'] = $queue_next_run;
		$job_status               = 'recurring';
	}

	$queued_jobs = get_option( 'sage_ai_bulk_queue_all_jobs' );
	if ( empty( $queued_jobs ) ) {
		$queued_jobs = array();
	}

	$id = sage_ai_create_unique_id( $queued_jobs );

	$log_file_path = sage_ai_get_plugin_log_file_path( $id . '.txt', 'read' );

	$queued_jobs[] = array(
		'articles_data' => $articles_data,
		'settings'      => $settings,
		'status'        => $job_status,
		'id'            => $id,
		'last_run'      => 'N/A',
		'log_file'      => $log_file_path,
		'name'          => $queueName,
	);

	// update queue jobs in WP options.
	update_option( 'sage_ai_bulk_queue_all_jobs', $queued_jobs );

	// stop kill process on every time user adding job.
	// update_option( 'sage_kill_processor_immediately', false );
	// update_option( 'sage_kill_processor_after_job', false );

	// $bulk_queue_processor = get_option( 'sage_ai_bulk_job_queue_processor' );

	// $is_processor_running = isset( $bulk_queue_processor['status'] ) ? $bulk_queue_processor['status'] : 'completed';

	// if ( $is_processor_running === 'completed' ) {
	// $is_processor_running = 'ready';
	// }

	// update_option( 'sage_ai_bulk_job_queue_processor', $bulk_queue_processor );

	$modify_queued_jobs = sage_ai_get_bulk_queue_data_with_changes();

	$queue_options = array(
		// 'processor'  => $is_processor_running,
		'queue_jobs' => $modify_queued_jobs,
	);

	wp_send_json_success( $queue_options );
}

add_action( 'wp_ajax_sage_ai_bulk_rss_call', 'sage_ai_bulk_rss_call' );

function sage_ai_bulk_rss_call() {

	$rssFeedUrl = stripslashes( $_POST['rssUrl'] );

	$article_count = stripslashes( $_POST['articleCount'] );

	$article_data = sage_ai_bulk_fetch_rss_data( $rssFeedUrl, $article_count );

	if ( $article_data === false ) {
		wp_send_json_error( 'The provided RSS URL is invalid. Please verify the URL and try again.' );
	}

	wp_send_json_success( $article_data );
	// $data = sage_ai_make_content_for_classic_editor($data);
}

function sage_ai_bulk_fetch_rss_data( $rssFeedUrl, $article_count ) {

	$rssFeed = file_get_contents( $rssFeedUrl );

	if ( $rssFeed === false ) {
		return false;
	}

	$xml = simplexml_load_string( $rssFeed );

	$article_data = array();

	foreach ( $xml->channel->item as $item ) {
		$title = (string) $item->title;

		// $description = (string) $item->description;

		$description    = strip_tags( $description );
		$article_data[] = array(
			'title'           => $title,
			'includeKeywords' => '',
			'excludeKeywords' => '',
			'imageKeyword'    => '',
			// 'description' => $description,
		);
		// $article_data[]['description'] = $description;

	}

	$article_data = array_slice( $article_data, 0, $article_count );

	return $article_data;
}


function sage_ai_get_pending_queue_jobs() {

	// all data.
	$bulk_queue_all_jobs = get_option( 'sage_ai_bulk_queue_all_jobs' );

	if ( ! is_array( $bulk_queue_all_jobs ) ) {
		$bulk_queue_all_jobs = array();
	}

	// completed data.
	$bulk_queue_completed_jobs = get_option( 'sage_ai_bulk_queue_completed_jobs' );

	if ( ! is_array( $bulk_queue_completed_jobs ) ) {
		$bulk_queue_completed_jobs = array();
	}

	$bulk_queue_processor_jobs = array();

	foreach ( $bulk_queue_all_jobs as $bulk_queued_job ) {

		$job_exist_in_completed = false;

		foreach ( $bulk_queue_completed_jobs as $bulk_queue_completed_job ) {

			if ( $bulk_queued_job['id'] === $bulk_queue_completed_job['id'] ) {

				$job_exist_in_completed = true;
				break;
			}
		}

		if ( $job_exist_in_completed === false ) {

			// only add job to pending jobs if it's timestamp is greater then current timestamp.
			$current_timestamp = new DateTime();
			$current_timestamp = $current_timestamp->getTimestamp();

			$queue_job_next_run = isset( $bulk_queued_job['settings']['queueNextRun'] ) ? $bulk_queued_job['settings']['queueNextRun'] : '';

			if ( ! ! $queue_job_next_run && $queue_job_next_run > $current_timestamp ) {
				continue;
			}

			$bulk_queue_processor_jobs[] = $bulk_queued_job;
		}
	}

	return $bulk_queue_processor_jobs;
}

function sage_ai_run_bulk_queue() {

	// when starting new process then empty the queue log file.
	sage_ai_erase_log_file( 'queue.txt' );

	$bulk_queue_processor = get_option( 'sage_ai_bulk_job_queue_processor' );

	$bulk_queue_processing_jobs = sage_ai_get_pending_queue_jobs();

	sage_ai_log_to_queue_file( 'Starting Queue Processor', 'queue.txt' );

	$bulk_queue_processor['status'] = 'running';

	update_option( 'sage_ai_bulk_job_queue_processor', $bulk_queue_processor );

	$post_url = array();

	while ( count( $bulk_queue_processing_jobs ) > 0 ) {

		// $kill_queue_after_job = get_option( 'sage_kill_processor_after_job' );

		// if user killed the processor after current queue then exit the loop and set the processor status to completed.
		// if ( ! empty( $kill_queue_after_job ) ) {

		// sage_ai_log_to_queue_file( 'Stopped by kill queue button' );

		// $bulk_queue_processor['status'] = 'completed';
		// update_option( 'sage_ai_bulk_job_queue_processor', $bulk_queue_processor );
		// update_option( 'sage_kill_processor_after_job', false );
		// break;

		// }

		// job to run at 0 index because we are using FIFO.
		$post_url = sage_ai_run_bulk_queue_job( $bulk_queue_processing_jobs[0] );

		// $kill_queue_immediately = get_option( 'sage_kill_processor_immediately' );

		// if user decided to kill the queue then after the article loop is exit then also exit queue loop.
		// if ( ! empty( $kill_queue_immediately ) ) {

		// sage_ai_log_to_queue_file( 'Stopped by kill processor button' );

		// $bulk_queue_processor['status'] = 'completed';
		// update_option( 'sage_ai_bulk_job_queue_processor', $bulk_queue_processor );
		// update_option( 'sage_kill_processor_immediately', false );

		// break;
		// }

		$queue_next_run = isset( $bulk_queue_processing_jobs[0]['settings']['queueNextRun'] ) ? $bulk_queue_processing_jobs[0]['settings']['queueNextRun'] : false;

		$queue_interval = isset( $bulk_queue_processing_jobs[0]['settings']['queueInterval'] ) ? $bulk_queue_processing_jobs[0]['settings']['queueInterval'] : false;

		// if job has next run and queue interval is set then don't move it to completed jobs.
		if ( ! ! $queue_next_run && ! ! $queue_interval ) {

			$queue_next_run_date = new DateTime();
			$queue_next_run_date->setTimestamp( $queue_next_run );

			$queue_next_run_date->modify( "+$queue_interval" );

			// update next run.
			$bulk_queue_processing_jobs[0]['settings']['queueNextRun'] = $queue_next_run_date->getTimestamp();

			// update job.
			sage_ai_update_single_job( $bulk_queue_processing_jobs[0] );

		} else {
			// removes to completed job from processing jobs.
			sage_ai_move_job_to_completed( $bulk_queue_processing_jobs[0] );
		}

		// remove first item.
		array_shift( $bulk_queue_processing_jobs );

		// when first queue is completed then again check for added queues.
		if ( count( $bulk_queue_processing_jobs ) === 0 ) {
			$bulk_queue_processing_jobs = sage_ai_get_pending_queue_jobs();
		}
	}

	sage_ai_log_to_queue_file( 'Stopping Queue Processor', 'queue.txt' );

	$bulk_queue_processor['status'] = 'completed';
	update_option( 'sage_ai_bulk_job_queue_processor', $bulk_queue_processor );

	return;
	// wp_send_json_success( $post_url );
}

function sage_ai_update_single_job( $updated_job ) {

	// all data.
	$bulk_queue_all_jobs = get_option( 'sage_ai_bulk_queue_all_jobs' );

	if ( ! is_array( $bulk_queue_all_jobs ) ) {
		$bulk_queue_all_jobs = array();
	}

	foreach ( $bulk_queue_all_jobs as $index => $bulk_queue_all_job ) {

		if ( $updated_job['id'] === $bulk_queue_all_job['id'] ) {
			$bulk_queue_all_jobs[ $index ] = $updated_job;
		}
	}

	update_option( 'sage_ai_bulk_queue_all_jobs', $bulk_queue_all_jobs );
}

function sage_ai_move_job_to_completed( $job ) {

	$bulk_queue_completed_jobs = get_option( 'sage_ai_bulk_queue_completed_jobs' );

	$bulk_queue_completed_jobs[] = $job;

	update_option( 'sage_ai_bulk_queue_completed_jobs', $bulk_queue_completed_jobs );
}



/**
 * Run queue.
 *
 * @return void
 */
function sage_ai_run_bulk_queue_job( $queued_job ) {

	$post_urls = array();

	$settings      = $queued_job['settings'];
	$articles_data = $queued_job['articles_data'];

	$job_id = isset( $queued_job['id'] ) ? $queued_job['id'] : false;

	if ( $job_id === false ) {
		return;
	}

	$job_log_file_name = $queued_job['id'] . '.txt';
	// rss data.
	$rss_url           = isset( $settings['rssUrl'] ) ? $settings['rssUrl'] : '';
	$rss_article_count = isset( $settings['rssArticleCount'] ) ? $settings['rssArticleCount'] : '';

	// fetch articles from rss feed.
	if ( ! empty( $rss_url ) && ! empty( $rss_article_count ) ) {

		$articles_data = sage_ai_bulk_fetch_rss_data( $rss_url, $rss_article_count );

		if ( $articles_data === false ) {
			sage_ai_log_to_queue_file( 'There seems to be a problem with the RSS URL.', 'queue.txt' );

			sage_ai_log_to_queue_file( 'There seems to be a problem with the RSS URL.', $job_log_file_name );
			return;
		}
	}

	// schedule interval is article publish date.
	$schedule_Interval       = isset( $settings['scheduleInterval'] ) ? isset( $settings['scheduleInterval'] ) : '0 minutes';
	$post_publish_date       = isset( $settings['postPublishDate'] ) ? $settings['postPublishDate'] : false;
	$post_type               = isset( $settings['postType'] ) ? $settings['postType'] : 'post';
	$taxonomies              = isset( $settings['taxonomies'] ) ? $settings['taxonomies'] : array();
	$post_status             = isset( $settings['postStatus'] ) ? $settings['postStatus'] : 'publish';
	$post_publish_date_stamp = false;

	// get article from qued job
	foreach ( $articles_data as $article_data ) {

		// sleep( 80 );

		// $kill_queue_immediately = get_option( 'sage_kill_processor_immediately' );

		// if user decided to kill the queue immediately then stop the artcile creating process.

		// if ( ! empty( $kill_queue_immediately ) ) {

		// break;
		// }

		$title = $article_data['title'];
		sage_ai_log_to_queue_file( 'Writing article for ' . $title, 'queue.txt' );

		sage_ai_log_to_queue_file( 'Writing article for ' . $title, $job_log_file_name );

		$structure = sage_ai_generate_post_structure( $article_data, $settings );

		$classic_editor_content = sage_ai_make_content_for_classic_editor( $structure );

		// only create timestamp if post status is schedule.
		if ( $post_status === 'future' ) {
			$post_publish_date       = new DateTime( $post_publish_date );
			$post_publish_date_stamp = $post_publish_date->getTimestamp();
		}

		$post_urls[] = sage_ai_generate_post( $classic_editor_content, $title, $post_status, $post_type, $settings['postCategories'], $post_publish_date_stamp, $taxonomies );

		sage_ai_log_to_queue_file( $title . ' Article created successfully', 'queue.txt' );
		sage_ai_log_to_queue_file( $title . ' Article created successfully', $job_log_file_name );

		// only create timestamp if post status is schedule.
		if ( $post_status === 'future' ) {
			$post_publish_date = sage_ai_interval_schedule_date( $post_publish_date, $schedule_Interval );
		}
	}

	return $post_urls;
}



/**
 * Generate unique id.
 *
 * @param array $data Data to check for existing ids.
 * @return string new unique id.
 */
function sage_ai_create_unique_id( $data, $length_of_string = 5 ) {

	// String of all alphanumeric character
	$str_result = '0123456789abcdefghijklmnopqrstuvwxyz';

	$unique_id = '';

	while ( empty( $unique_id ) ) {

		// Shuffle the $str_result and returns substring
		// of specified length
		$unique_id = substr(
			str_shuffle( $str_result ),
			0,
			$length_of_string
		);

		foreach ( $data as $data_item ) {

			if ( $data_item['id'] === $unique_id ) {
				$unique_id = '';
				break;
			}
		}
	}

	return $unique_id;
}

/**
 * Add Interval for next post.
 *
 * @param string $post_publish_date previous post date as timestamp.
 * @param string $schedule_Interval Interval between posts. eg 5 min. 1hour, 1day etc..
 * @return date next post publish date.
 */
function sage_ai_interval_schedule_date( $post_publish_date, $schedule_Interval ) {

	$post_publish_date->modify( "+$schedule_Interval" );

	$post_publish_date = $post_publish_date->format( 'Y-m-d H:i:s' );

	return $post_publish_date;
}


// add_action( 'init', 'test_init' );

function test_init() {

	$processor           = get_option( 'sage_ai_bulk_job_queue_processor' );
	$processor['status'] = 'completed';

	update_option( 'sage_ai_bulk_job_queue_processor', $processor );
}


add_action( 'wp_ajax_sage_ai_get_post_type_taxonomies_data', 'sage_ai_get_post_type_taxonomies_data' );

function sage_ai_get_post_type_taxonomies_data() {

	$post_type = stripslashes( $_POST['postType'] );
	$post_type = json_decode( $post_type, true );

	if ( empty( $post_type ) ) {
		wp_send_json_error( 'Invalid Value of Post Type' );
	}

		$taxonomies = get_object_taxonomies( $post_type, 'object' );

		$taxonomies_data = array();

	if ( ! empty( $taxonomies ) ) {
		// get the term data of that taxonomy. which is like all categories, tags.
		foreach ( $taxonomies as $taxonomy ) {

			// get data of taxonomy
			$taxonomy_terms = get_terms(
				array(
					'taxonomy'   => $taxonomy->name,
					'hide_empty' => false,
				)
			);

			$taxonomies_data[] = array(
				'name'  => $taxonomy->name,
				'label' => $taxonomy->label,
				'data'  => $taxonomy_terms,
			);
		}
	}

		wp_send_json_success( $taxonomies_data );
}


add_action( 'wp_ajax_sage_ai_queue_heartbeat', 'sage_ai_queue_heartbeat' );

function sage_ai_queue_heartbeat() {

	$queue_log = sage_ai_read_log_file( 'queue.txt' );

	if ( empty( $queue_log ) ) {
		$queue_log = array();
	}

	$bulk_queue_all_jobs = sage_ai_get_bulk_queue_data_with_changes();

	$processor = get_option( 'sage_ai_bulk_job_queue_processor' );

	$queue_data = array(
		'jobs'      => $bulk_queue_all_jobs,
		'processor' => $processor['status'],
		'log'       => $queue_log,
	);

	wp_send_json_success( $queue_data );
}


function sage_ai_get_bulk_queue_data_with_changes() {

	// all data.
	$bulk_queue_all_jobs = get_option( 'sage_ai_bulk_queue_all_jobs' );

	if ( ! is_array( $bulk_queue_all_jobs ) ) {
		$bulk_queue_all_jobs = array();
	}

	// completed data.
	$bulk_queue_completed_jobs = get_option( 'sage_ai_bulk_queue_completed_jobs' );

	if ( ! is_array( $bulk_queue_completed_jobs ) ) {
		$bulk_queue_completed_jobs = array();
	}

	// compare user jobs with completed jobs.
	// if found then change user job status to completed.
	foreach ( $bulk_queue_all_jobs as $bulk_queued_job_index => $bulk_queued_job ) {

		$log_file_path = sage_ai_get_plugin_log_file_path( $bulk_queued_job['id'] . '.txt', 'read' );

		if ( ! empty( $log_file_path ) ) {
			$bulk_queue_all_jobs[ $bulk_queued_job_index ]['log_file'] = $log_file_path;
		}

		foreach ( $bulk_queue_completed_jobs as $bulk_queue_completed_job ) {

			if ( $bulk_queued_job['id'] === $bulk_queue_completed_job['id'] ) {

				$bulk_queue_all_jobs[ $bulk_queued_job_index ]['status'] = 'completed';
				break;

			}
		}
	}

	return $bulk_queue_all_jobs;
}


// add_action( 'init', 'sage_ai_init' );

function sage_ai_init() {
	error_log( 'fdodo' );

	// delete_option( 'sage_ai_bulk_queue_completed_jobs' );
	// delete_option( 'sage_ai_bulk_job_queue_processor' );
	// delete_option( 'sage_ai_bulk_queue_all_jobs' );

	// $bulk_queue_completed = get_option( 'sage_ai_bulk_job_queue_processor' );

	// $kill_queue_immediately = get_option( 'sage_kill_processor_immediately' );
	// $kill_queue_after_job   = get_option( 'sage_kill_processor_after_job' );

	// $bulk_queue_all_jobs = get_option( 'sage_ai_bulk_queue_all_jobs' );

	// var_dump( $bulk_queue_completed );
	// var_dump( $kill_queue_immediately );
	// var_dump( $kill_queue_after_job );
	// // var_dump( $bulk_queue_all_jobs );
	// die;
}



add_action( 'wp_ajax_sage_ai_read_queue_log_file_call', 'sage_ai_read_queue_log_file_call' );

function sage_ai_read_queue_log_file_call() {

	$queue_log = sage_ai_read_log_file( 'queue.txt' );

	if ( empty( $queue_log ) ) {
		$queue_log = array();
	}

	wp_send_json_success( $queue_log );
}
