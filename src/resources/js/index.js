/** global: Craft */
/** global: Garnish */
/**
 * EntryTemplates class
 */

if (typeof Craft.EntryTemplates === typeof undefined) {
	Craft.EntryTemplates = {};
}

Craft.EntryTemplates.TemplateIndex = Craft.BaseElementIndex.extend({
	$newTemplateBtnGroup: null,
	$newTemplateBtn: null,
	init(elements, main, controller) {
		this.on("selectSource", this.createButton.bind(this));

		this.on("selectSite", this.createButton.bind(this));

		this.base(elements, main, controller);
	},
	afterInit: function () {
		this.entryTypes = Craft.sendActionRequest("POST", "entrytemplates/templates/types").catch(
			(t) => console.warn("Unable to get entry types"),
		);
	},
	createButton: function () {
		if (null === this.$source) return;

		null !== this.$newTemplateBtnGroup && this.$newTemplateBtnGroup.remove(),
			(this.$newTemplateBtnGroup = $('<div class="btngroup submit" data-wrapper/>'));

		this.$newTemplateBtn = Craft.ui
			.createButton({
				label: Craft.t("entrytemplates", "New template"),
				spinner: true,
			})
			.addClass("submit add icon")
			.appendTo(this.$newTemplateBtnGroup);

		this.addListener(this.$newTemplateBtn, "click", () => {
			this._createTemplate();
		});

		this.addButton(this.$newTemplateBtnGroup);
	},
	_createTemplate: async function () {
		const table = this.$source.data("handle");
		let elements = await this.entryTypes;

		elements = elements.data.entryTypes;

		const element = elements[table];

		Craft.sendActionRequest("POST", "entrytemplates/templates/create", {
			data: {
				siteId: this.siteId,
				entryType: element.handle,
				sections: element.sections,
			},
		}).then(({ data: table }) => {
			document.location.href = Craft.getUrl(table.cpEditUrl, {
				fresh: 1,
			});
		});
	},
});

Craft.registerElementIndexClass(
	"fortytwostudio\\entrytemplates\\elements\\EntryTemplate",
	Craft.EntryTemplates.TemplateIndex,
);
