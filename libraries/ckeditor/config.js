/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 config.language = 'en';
	 //config.uiColor = '#0D0D0D';
	 config.toolbarGroups = [
	         		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	 				{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
	 				{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
	 				'/',
	 				{ name: 'forms' },
	 				{ name: 'insert' },
	 				{ name: 'links' },
	 				'/',
	 				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	 				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
	 				'/',
	 				{ name: 'styles' },
	 				{ name: 'colors' },
	 				{ name: 'tools' },
	 				{ name: 'others' },
	 				{ name: 'about' }
	         	];
	config.filebrowserBrowseUrl = '../libraries/ckeditor/plugins/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '../libraries/ckeditor/plugins/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = '../libraries/ckeditor/plugins/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl = '../libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '../libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = '../libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
