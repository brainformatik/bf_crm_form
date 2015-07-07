Ext.namespace('TYPO3.Form.Wizard.Viewport.Left.Options.Forms');

/**
 * The label properties and the layout of the element
 *
 * @class TYPO3.Form.Wizard.Viewport.Left.Options.Forms.Crmfield
 * @extends Ext.FormPanel
 */
TYPO3.Form.Wizard.Viewport.Left.Options.Forms.Crmfield = Ext.extend(Ext.FormPanel, {
    /**
     * @cfg {String} title
     *
     * The title text to be used as innerHTML (html tags are accepted) to
     * display in the panel header (defaults to '').
     */
    title: TYPO3.l10n.localize('crmfield'),

    /**
     * @cfg {String} defaultType
     *
     * The default xtype of child Components to create in this Container when
     * a child item is specified as a raw configuration object,
     * rather than as an instantiated Component.
     *
     * Defaults to 'panel', except Ext.menu.Menu which defaults to 'menuitem',
     * and Ext.Toolbar and Ext.ButtonGroup which default to 'button'.
     */
    defaultType: 'textfield',

    /**
     * @cfg {Boolean} monitorValid
     *
     * If true, the form monitors its valid state client-side and
     * regularly fires the clientvalidation event passing that state.
     * When monitoring valid state, the FormPanel enables/disables any of its configured
     * buttons which have been configured with formBind: true depending
     * on whether the form is valid or not. Defaults to false
     */
    monitorValid: false,

    initComponent: function () {
        var fields = this.getFieldsBySettings();
        var formItems = [];

        Ext.iterate(fields, function (item, index, allItems) {
            switch (item) {
                case 'value':
                    formItems.push({
                        fieldLabel: TYPO3.l10n.localize('crmfield_name'),
                        name: 'value',
                        listeners: {
                            'triggerclick': {
                                scope: this,
                                fn: this.storeValue
                            }
                        }
                    });
                    break;
                //@todo filters
            }
        }, this);

        var config = {
            items: [{
                xtype: 'fieldset',
                title: '',
                border: false,
                autoHeight: true,
                defaults: {
                    width: 150,
                    msgTarget: 'side'
                },
                defaultType: 'textfieldsubmit',
                items: formItems
            }]
        };

        Ext.apply(this, Ext.apply(this.initialConfig, config));

        TYPO3.Form.Wizard.Viewport.Left.Options.Forms.Crmfield.superclass.initComponent.apply(this, arguments);

        this.on('clientvalidation', this.validation, this);

        this.fillForm();
    },

    /**
     * Add the configuration object to this component
     *
     * @param config
     */
    constructor: function (config) {
        this.addEvents({
            'validation': true
        });

        TYPO3.Form.Wizard.Viewport.Left.Options.Forms.Crmfield.superclass.constructor.call(this, config);
    },

    /**
     * Store a changed value from the form in the element
     *
     * @param {Object} field The field which has changed
     */
    storeValue: function (field) {
        if (field.isValid()) {
            var fieldName = field.getName();

            var formConfiguration = {crmfield: {}};
            formConfiguration.crmfield[fieldName] = field.getValue();

            this.element.setConfigurationValue(formConfiguration);
        }
    },

    /**
     * Fill the form with the configuration of the element
     *
     * @return void
     */
    fillForm: function () {
        this.getForm().setValues(this.element.configuration.crmfield);
    },

    /**
     * Get the fields for the element
     *
     * Based on the TSconfig general allowed fields
     * and the TSconfig allowed fields for this type of element
     *
     * @returns object
     */
    getFieldsBySettings: function () {
        var fields = [];

        try {
            fields = TYPO3.Form.Wizard.Settings.defaults.tabs.options.accordions.crmfield.showProperties.split(/[, ]+/);
        } catch (error) {
            fields = [
                'value'
            ];
        }

        return fields;
    },

    /**
     * Adds or removes the error class if the form is valid or not
     *
     * @param {Object} formPanel
     * @param {Boolean} valid
     */
    validation: function (formPanel, valid) {
        if (this.el) {
            if (valid && this.el.hasClass('validation-error')) {
                this.removeClass('validation-error');
                this.fireEvent('validation', 'label', valid);
            } else if (!valid && !this.el.hasClass('validation-error')) {
                this.addClass('validation-error');
                this.fireEvent('validation', 'label', valid);
            }
        }
    }
});

Ext.reg('typo3-form-wizard-viewport-left-options-forms-crmfield', TYPO3.Form.Wizard.Viewport.Left.Options.Forms.Crmfield);