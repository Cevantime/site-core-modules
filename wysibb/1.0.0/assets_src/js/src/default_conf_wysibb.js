// à renommer, à placer dans le répertoire assets_src et à modifier selon besoin

require('wysibb');

var $ = require('jquery');

var openFileBrowser = require('./compiled/filebrowser');

var openFile = function (command, value, queryState) {
	var those = this;
	openFileBrowser({
		callback: function (file) {
			
			those.wbbInsertCallback(command, {TYPE:"zip",SELTEXT:baseURL+file.src});
		}
	});
};

var wbbOpt = {
	hotkeys: false, //disable hotkeys (native browser combinations will work)
	showHotkeys: false, //hide combination in the tooltip when you hover.
	lang: "fr",
	buttons: 'bold,italic,underline,strike,sup,sub,|,h2,h3,h4,h5,h6,|,img,video,link,|,bullist,numlist,|,fontcolor,fontsize,fontfamily,|,justifyleft,justifycenter,justifyright,|,myquote,insertfile,code,table,removeFormat',
	allButtons: {
		targetlink: {
			title: 'New page link',
			buttonHTML: '<span class="fonticon ve-tlb-link1">\uE007</span>',
			modal: {
				title: 'modal_link_title',
				width: "500px",
				tabs: [
					{
						input: [
							{param: "SELTEXT", title: CURLANG.modal_link_text, type: "div"},
							{param: "URL", title: CURLANG.modal_link_url, validation: '^http(s)?://'}
						]
					}
				]
			},
			transform: {
				'<a href="{URL}" target="_blank">{SELTEXT}</a>': "[urlblank={URL}]{SELTEXT}[/urlblank]",
				'<a href="{URL}" target="_blank">{URL}</a>': "[urlblank]{URL}[/urlblank]"
			}
		},
		h2: {
			title: 'h2',
			buttonText: 'h2',
			transform: {
				'<h2>{SELTEXT}</h2>': '[h2]{SELTEXT}[/h2]'
			}
		},
		h3: {
			title: 'h3',
			buttonText: 'h3',
			transform: {
				'<h3>{SELTEXT}</h3>': '[h3]{SELTEXT}[/h3]'
			}
		},
		h4: {
			title: 'h4',
			buttonText: 'h4',
			transform: {
				'<h4>{SELTEXT}</h4>': '[h4]{SELTEXT}[/h4]'
			}
		},
		h5: {
			title: 'h5',
			buttonText: 'h5',
			transform: {
				'<h5>{SELTEXT}</h5>': '[h5]{SELTEXT}[/h5]'
			}
		},
		h6: {
			title: 'h6',
			buttonText: 'h6',
			transform: {
				'<h6>{SELTEXT}</h6>': '[h6]{SELTEXT}[/h6]'
			}
		},
		myquote: {
			title: 'Insert myquote',
			buttonText: 'myquote',
			transform: {
				'<div class="myquote">{SELTEXT}</div>': '[myquote]{SELTEXT}[/myquote]'
			}
		},
		img: {
			title: "Insert your own images !",
			cmd: openFile,
			transform: {
				'<img src="{SELTEXT}" />': '[file=image]{SELTEXT}[/file]',
				'<div class="zip" data-source="{TYPE}"><img src="{SELTEXT}"/></div>' : '[file=zip]{SELTEXT}[/file]'
			}
		}
	}
}

$('textarea').wysibb(wbbOpt);




