/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
config.scayt_autoStartup = true;
config.scayt_sLang = 'el_GR';
config.toolbar = 'MyToolbar'; 
	config.toolbar_MyToolbar =
	[		
		{ name: 'clipboard', items : ['Source', 'PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },
		{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
		{ name: 'tools', items : [ 'Maximize'] },
                '/',
		{ name: 'styles', items : ['Format' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic'] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ,'CreateDiv',
		'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },

	];
};
