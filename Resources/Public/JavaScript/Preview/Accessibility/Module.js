TtreePluginSeoAccessibilityPreview = {
	init: function() {
		var guidGenerator = function() {
			var S4 = function() {
				return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
			};
			return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
		};

		var configuration = new axs.AuditConfiguration();
		configuration.scope = document.querySelector('#ttree-plugin-seo-accessibility-wrapper');
		configuration.ignoreSelectors('.neos-pageloader-wrapper');

		var report = axs.Audit.run(configuration),
			processedReport = {
				NA: [],
				FAIL: [],
				PASS: [],
				TOTAL: []
			};
		report.forEach(function(entry) {
			var result = entry.result;
			processedReport[result].push(entry);
			processedReport['TOTAL'].push(entry);
			if (entry.elements !== undefined && entry.elements.length) {
				console.log(entry);
				entry.elements.forEach(function(element){
					var c = m = undefined;
					var elementUuid = 'ttree-plugin-seo-accessibility-' + guidGenerator();

					switch (result) {
						case 'FAIL':
							c = elementUuid + ' ttree-plugin-seo-accessibility ttree-plugin-seo-accessibility-fail';
							m = 'Failed';
							break;
						case 'PASS':
							c = elementUuid + ' ttree-plugin-seo-accessibility ttree-plugin-seo-accessibility-pass';
							m = 'Passed';
							break;
					}
					if (c !== undefined) {
						var boxUuid = 'ttree-plugin-seo-accessibility-' + guidGenerator(),
							el = document.createElement('div');

						console.log(entry.rule);
						$(el).addClass(c).data('heading', entry.rule.heading).html('<div class="accessible-tooltip" data-toggle="tooltip" data-placement="top" title="' + entry.rule.heading + '">&nbsp;</div>');

						$(element).addClass(boxUuid + ' ttree-plugin-seo-accessibility-content-box');
						$(element).append(el);
						new Tether({
							element: '.' + elementUuid,
							target: '.' + boxUuid,
							attachment: 'top center',
							targetAttachment: 'top center',
							targetOffset: '-10px 0'
						});
					}
				});
			}
		});

		$("#ttree-plugin-seo-accessibility-panel .resume.resume-na > .resume-value").html(processedReport['NA'].length);
		$("#ttree-plugin-seo-accessibility-panel .resume.resume-fail > .resume-value").html(processedReport['FAIL'].length);
		$("#ttree-plugin-seo-accessibility-panel .resume.resume-pass > .resume-value").html(processedReport['PASS'].length);
		$("#ttree-plugin-seo-accessibility-panel .resume-total").html(processedReport['TOTAL'].length);
		$('.accessible-tooltip').tooltip();
	}
};

$(function() {
	TtreePluginSeoAccessibilityPreview.init();
});
document.addEventListener('Neos.PageLoaded', function(event) {
	setTimeout(function(){
		TtreePluginSeoAccessibilityPreview.init();
	}, 1000);
}, false);
