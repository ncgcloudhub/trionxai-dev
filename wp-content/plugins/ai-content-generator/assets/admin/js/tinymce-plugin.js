(function ($) {
	tinymce.PluginManager.add('sageaibutton', function (editor, url) {
		let globalSettings = JSON.parse(wp_ai_content_var);
		let ajaxUrl = globalSettings.sageAjaxUrl;
		let apiKey = globalSettings.apiKey;

		let sageAIItems = globalSettings.aiAssistantPrompts.map((menuItem) => {
			return {
				text: menuItem.name,
				onclick: function () {
					let html = editor.selection.getContent({
						format: 'html',
					});
					let text = editor.selection.getContent({
						format: 'text',
					});
					if ('' === text) {
						alert('No text selected');
					} else {
						let prompt = menuItem.value.replace(
							/\[content\]/g,
							text
						);
						let selectionWithLoader =
							'#sageAI ' +
							html +
							' <img class="sage-loader" src="' +
							globalSettings.pluginUrl +
							'/assets/img/loader.gif" width="15px"/> sageAI# ';
						window.send_to_editor(selectionWithLoader);

						sageAIMakeCall(
							html,
							prompt,
							editor,
							ajaxUrl,
							menuItem.replaceText
						);
					}
				},
			};
		});

		if (apiKey === '') {
			sageAIItems = [];
			sageAIItems.push({
				text: 'Open AI key not set',
				onclick: function () {
					alert('Please set your OpenAI api key.');
				},
			});
		}

		editor.addButton('sageaibutton', {
			text: 'Sage AI',
			icon: false,
			type: 'menubutton',
			menu: sageAIItems,
		});
	});

	function sageAIMakeCall(html, prompt, editor, ajaxUrl, replaceText) {
		jQuery.ajax({
			url: ajaxUrl,
			data: {
				action: 'sage_ai_call_open_ai',
				prompt: prompt,
			},
			dataType: 'JSON',
			type: 'POST',
			success: function (response) {
				let result = response.data;
				let finalContent = '';
				// if (result.error !== undefined) {
				// 	alert(result.error.message);
				// 	finalContent = html;
				// }

				if (result !== undefined) {
					finalContent = replaceText
						? result
						: html + '<br>' + result;
				}

				let editorContent = editor.getContent();
				editorContent = editorContent.replace(
					/\#sageAI.*sageAI\#/g,
					finalContent
				);

				editor.setContent(editorContent);
			},
		});
	}
})(jQuery);
