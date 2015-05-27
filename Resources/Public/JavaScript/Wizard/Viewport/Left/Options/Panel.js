Ext.namespace('BF.BfCrmForm.Panel');

/**
 * Save temporarily panel function named getAccordionsBySettings
 *
 * @type {Function}
 */
BF.BfCrmForm.Panel.getAccordionsBySettings = TYPO3.Form.Wizard.Viewport.Left.Options.Panel.prototype.getAccordionsBySettings;

/**
 * Elements in which the crm field is allowed
 *
 * @type {Array}
 */
BF.BfCrmForm.Panel.elements = ['textline', 'textarea', 'password', 'hidden', 'checkbox', 'checkboxgroup', 'radio', 'radiogroup', 'select'];

/**
 * Override panel function named getAccordionsBySettings
 *
 * @type TYPO3.Form.Wizard.Viewport.Left.Options.Panel.prototype.getAccordionsBySettings
 */
TYPO3.Form.Wizard.Viewport.Left.Options.Panel.prototype.getAccordionsBySettings = function() {
    if (this.element && !this.element.configuration['crmfield'] && BF.BfCrmForm.Panel.elements.indexOf(this.element.xtype.split('-').pop()) !== -1) {
        this.element.configuration['crmfield'] = {value:''};
    }

    return BF.BfCrmForm.Panel.getAccordionsBySettings.apply(this);
};