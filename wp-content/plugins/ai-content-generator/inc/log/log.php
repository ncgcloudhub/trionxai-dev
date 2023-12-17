<?php

// Define the log file path

/**
 * check if log file path exists
 *
 * @param [type] $file_name The name of file which to look for.
 * @param [type] $action Wether to only check the path or create new file path.
 * @return string file path;
 */
function sage_ai_get_plugin_log_file_path( $file_name, $action = 'write' ) {

	$log_directory = wp_upload_dir();
	$log_directory = $log_directory['basedir'] . '/sage-ai-writer/';

	// if action read then return the file path without cretaing it.
	if ( $action === 'read' ) {

		if ( file_exists( $log_directory ) ) {

			$log_file = $log_directory . $file_name;

			if ( file_exists( $log_file ) ) {
				$log_directory_url = wp_upload_dir();
				$log_directory_url = $log_directory_url['baseurl'] . '/sage-ai-writer/' . $file_name;
				return $log_directory_url;
			}
		}

		return '';
	}

	// Create the log directory if it doesn't exist
	if ( ! file_exists( $log_directory ) ) {

		if ( wp_mkdir_p( $log_directory ) ) {
			// Directory created successfully
		} else {
			// Failed to create the directory
			error_log( 'Failed to create the log directory: ' . $log_directory );
		}
	}

	$log_file = $log_directory . $file_name;

	// Create the log file if it doesn't exist
	if ( ! file_exists( $log_file ) ) {
		if ( touch( $log_file ) ) {
			// File created successfully
		} else {
			// Failed to create the file
			error_log( 'Failed to create the log file: ' . $log_file );
		}
	}

	return $log_file;
}


function sage_ai_log_file_exists() {
}


// Function to log messages
function sage_ai_log_to_queue_file( $message, $fileName ) {

	$log_file = sage_ai_get_plugin_log_file_path( $fileName, 'write' );

	$log_message = date( 'Y-m-d H:i:s' ) . ' - ' . $message . "\n";

	if ( file_exists( $log_file ) || is_writable( dirname( $log_file ) ) ) {
		file_put_contents( $log_file, $log_message, FILE_APPEND );
	} else {
		error_log( 'Failed to write to log file: ' . $log_file );
	}
}


// read file
function sage_ai_read_log_file( $fileName ) {

	$log_file_name = $fileName; // Replace with your log file name

	$log_directory = wp_upload_dir();
	$log_directory = $log_directory['basedir'] . '/sage-ai-writer/';
	$log_file      = $log_directory . $log_file_name;

	// Open the log file for reading
	$handle = fopen( $log_file, 'r' );

	if ( $handle === false ) {
		return false; // Failed to open the file
	}

	// Find the file size
	fseek( $handle, 0, SEEK_END );

	$fileSize = ftell( $handle );

	$chunkSize      = 4096; // Size of each chunk to read
	$lines          = array();
	$remainingLines = 100; // Number of lines to read

	while ( $remainingLines > 0 && $fileSize > 0 ) {

		$chunkSize = min( $chunkSize, $fileSize );

		fseek( $handle, -$chunkSize, SEEK_CUR );

		$data      = fread( $handle, $chunkSize );
		$fileSize -= $chunkSize;

		// Split data into lines
		$lines           = array_merge( array_filter( explode( "\n", $data ) ) );
		$remainingLines -= count( $lines );
	}

	fclose( $handle );

	// Extract the last 100 lines
	$last100Lines = array_slice( $lines, -$remainingLines );

	return $last100Lines;
}


function sage_ai_erase_log_file( $fileName ) {

	$log_directory = wp_upload_dir();
	$log_directory = $log_directory['basedir'] . '/sage-ai-writer/';
	$log_file      = $log_directory . $fileName;

	// Open the log file in write mode, which truncates the file
	$handle = fopen( $log_file, 'w' );

	if ( $handle === false ) {
		return 'Failed to open the log file.';
	} else {
		fclose( $handle );
		return 'Log file content has been removed.';
	}
}
