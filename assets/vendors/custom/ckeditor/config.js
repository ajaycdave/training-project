/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html
	config.mathJaxLib = '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML';
	config.extraPlugins = 'mathjax';
	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection'] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		//{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		/*{ name: 'others' },
		'/',*/
		{ name: 'basicstyles', groups: [ 'basicstyles'] },
		{ name: 'paragraph',   groups: [ 'list'] },
		{ name: 'styles' },
		{ name: 'colors' },
		//{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	config.filebrowserUploadMethod = 'form';
	//KCfinder
	/*config.filebrowserBrowseUrl = '../assets/vendors/custom/kcfinder/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl = '../assets/vendors/custom/kcfinder/browse.php?opener=ckeditor&type=images';
	config.filebrowserFlashBrowseUrl = '../assets/vendors/custom/kcfinder/browse.php?opener=ckeditor&type=flash';
	config.filebrowserUploadUrl = '../assets/vendors/custom/kcfinder/upload.php?opener=ckeditor&type=files';
	config.filebrowserImageUploadUrl = '../assets/vendors/custom/kcfinder/upload.php?opener=ckeditor&type=images';
	config.filebrowserFlashUploadUrl = '../assets/vendors/custom/kcfinder/upload.php?opener=ckeditor&type=flash';*/
	config.filebrowserBrowseUrl = APP_URL+'/assets/vendors/custom/kcfinder/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl = APP_URL+'/assets/vendors/custom/kcfinder/browse.php?opener=ckeditor&type=images';
	config.filebrowserFlashBrowseUrl = APP_URL+'/assets/vendors/custom/kcfinder/browse.php?opener=ckeditor&type=flash';
	config.filebrowserUploadUrl = APP_URL+'/assets/vendors/custom/kcfinder/upload.php?opener=ckeditor&type=files';
	config.filebrowserImageUploadUrl = APP_URL+'/assets/vendors/custom/kcfinder/upload.php?opener=ckeditor&type=images';
	config.filebrowserFlashUploadUrl = APP_URL+'/assets/vendors/custom/kcfinder/upload.php?opener=ckeditor&type=flash';
};
