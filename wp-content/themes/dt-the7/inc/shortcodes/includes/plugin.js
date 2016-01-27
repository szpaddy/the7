(function() {

	tinymce.PluginManager.add( 'the7_shortcodes', function( editor, url ) {

		editor.addButton( 'the7_chortcodes_megabutton', {

			type: 'menubutton',

			text: '简码',
			tooltip: 'The7简码',

			icon: false,

			menu:
			[
				// Gap
				{
					text: '空隙',
					onclick: function() {
						editor.insertContent( '[dt_gap height="10" /]' );
					}
				},

				// Divider
				{
					text: '分隔线',
					menu:
					[
						{
							text: '细',
							onclick: function() {
								editor.insertContent( '[dt_divider style="thin" /]' );
							}
						},

						{
							text: '粗',
							onclick: function() {
								editor.insertContent( '[dt_divider style="thick" /]' );
							}
						}
					]
				},

				// List
				{
					text: '列表',
					menu:
					[
						{
							text: '列表',
							onclick: function() {

								var attr = ['style="1"', 'bullet_position="middle"', 'dividers="true"'],

									content = [
										'[dt_list_item image=""]CONTENT[/dt_list_item]',
										'[dt_list_item image=""]CONTENT[/dt_list_item]',
										'[dt_list_item image=""]CONTENT[/dt_list_item]'
									];

								editor.insertContent( '[dt_list ' + attr.join(' ') + ']' + content.join('') + '[/dt_list]' );
							}
						},

						{
							text: '项目',
							onclick: function() {
								editor.insertContent( '[dt_list_item image=""]CONTENT[/dt_list_item]' );
							}
						}
					]
				},

				// Button
				{
					text: '按钮',
					menu:
					[
						{
							text : '链接',
							onclick : function() {

								var attr = [
										'size="link"',
										'animation="none"',
										'icon=""',
										'icon_align="left"',
										'color=""',
										'link=""',
										'target_blank="true"'
									],
									attr_str = attr.join(' ');

								editor.insertContent( '[dt_button ' + attr_str + ']BUTTON[/dt_button]' );
							}
						},

						{
							text : '小',
							onclick : function() {

								var attr = [
										'size="small"',
										'animation="none"',
										'icon=""',
										'icon_align="left"',
										'color=""',
										'link=""',
										'target_blank="true"'
									],
									attr_str = attr.join(' ');

								editor.insertContent( '[dt_button ' + attr_str + ']BUTTON[/dt_button]' );
							}
						},

						{
							text : '中',
							onclick : function() {

								var attr = [
										'size="medium"',
										'animation="none"',
										'icon=""',
										'icon_align="left"',
										'color=""',
										'link=""',
										'target_blank="true"'
									],
									attr_str = attr.join(' ');

								editor.insertContent( '[dt_button ' + attr_str + ']BUTTON[/dt_button]' );
							}
						},

						{
							text : '大',
							onclick : function() {

								var attr = [
										'size="big"',
										'animation="none"',
										'icon=""',
										'icon_align="left"',
										'color=""',
										'link=""',
										'target_blank="true"'
									],
									attr_str = attr.join(' ');

								editor.insertContent( '[dt_button ' + attr_str + ']BUTTON[/dt_button]' );
							}
						}
					]
				},

				// Tooltip
				{
					text: '工具提示',
					onclick: function() {
						editor.insertContent( '[dt_tooltip title="TITLE"]' + editor.selection.getContent() + '[/dt_tooltip]' );
					}
				},

				// Highlight
				{
					text: '高亮',
					onclick: function() {
						editor.insertContent( '[dt_highlight color=""]' + editor.selection.getContent() + '[/dt_highlight]' );
					}
				},

				// Code
				{
					text: '代码',
					onclick: function() {
						editor.insertContent( '[dt_code]' + editor.selection.getContent() + '[/dt_code]' );
					}
				},

				// Social icons
				{
					text: '社会化图标',
					onclick: function() {
						var items = [
								'[dt_social_icon target_blank="true" icon="facebook" link="" /]',
								'[dt_social_icon target_blank="true" icon="twitter" link="" /]',
								'[dt_social_icon target_blank="true" icon="google" link="" /]'
							];

						editor.insertContent( '[dt_social_icons animation="none"]' + items.join('') + '[/dt_social_icons]' );
					}
				},

				// Fancy media
				{
					text: '梦幻媒体',
					onclick: function() {

						var attr = [
								'type=""',
								'style="1"',
								'lightbox="0"',
								'align=""',
								'padding="0"',
								'margin_top="0"',
								'margin_bottom="0"',
								'margin_right="0"',
								'margin_left="0"',
								'width=""',
								'animation="none"',
								'media=""',
								'image_alt=""',
								'hd_image=""',
								'image=""'
							];

						editor.insertContent( '[dt_fancy_image ' + attr.join(' ') + ']' + editor.selection.getContent() + '[/dt_fancy_image]' );
					}
				},

				// Quote
				{
					text: '引用',
					menu:
					[
						{
							text : '抽取引用',
							onclick : function() {

								var attr = [
										'type="pullquote"',
										'layout="left"',
										'font_size="normal"',
										'animation="none"',
										'size="1"',
									];

								editor.insertContent( '[dt_quote ' + attr.join(' ') + ']CONTENT[/dt_quote]' );
							}
						},

						{
							text : '块引用',
							onclick : function() {

								var attr = [
										'type="blockquote"',
										'font_size="normal"',
										'animation="none"',
										'background="plain"'
									];

								editor.insertContent( '[dt_quote ' + attr.join(' ') + ']CONTENT[/dt_quote]' );
							}
						}
					]
				},

				// Progress bars
				{
					text: '渐进条',
					menu:
					[
						{
							text : '渐进条',
							onclick : function() {

								var attr = [
										'title="标题"',
										'color=""',
										'percentage=""'
									],
									attr_str = attr.join(' '),
									bars = [
										'[dt_progress_bar ' + attr_str + ' /]',
										'[dt_progress_bar ' + attr_str + ' /]',
										'[dt_progress_bar ' + attr_str + ' /]'
									];

								editor.insertContent( '[dt_progress_bars show_percentage="true"]' + bars.join('') + '[/dt_progress_bars]' );
							}
						},

						{
							text : '渐进条2',
							onclick : function() {

								var attr = [
										'title="标题"',
										'color=""',
										'percentage=""'
									];

								editor.insertContent( '[dt_progress_bar ' + attr.join(' ') + ' /]' );
							}
						}
					]
				}

			]

		} );

	});

})();