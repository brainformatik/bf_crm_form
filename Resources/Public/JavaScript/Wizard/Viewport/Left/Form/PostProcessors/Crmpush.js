Ext.namespace('TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors');

/**
 * The mail post processor
 *
 * @class TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.Crmpush
 * @extends TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.PostProcessor
 */
TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.Crmpush = Ext.extend(TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.PostProcessor, {
    /**
     * @cfg {String} processor
     *
     * The name of this processor
     */
    processor: 'crmpush',

    initComponent: function() {
        var fields = this.getFieldsBySettings();
        var formItems = new Array();

        this.addEvents({
            'validation': true
        });

        Ext.iterate(fields, function(item, index, allItems) {
            switch(item) {
                case 'url':
                    formItems.push({
                        fieldLabel: TYPO3.l10n.localize('crmpush_url'),
                        name: 'url',
                        allowBlank: false,
                        listeners: {
                            'triggerclick': {
                                scope: this,
                                fn: this.storeValue
                            }
                        }
                    });
                    break;
                case 'username':
                    formItems.push({
                        fieldLabel: TYPO3.l10n.localize('crmpush_username'),
                        name: 'username',
                        allowBlank: false,
                        listeners: {
                            'triggerclick': {
                                scope: this,
                                fn: this.storeValue
                            }
                        }
                    });
                    break;
                case 'accesskey':
                    formItems.push({
                        fieldLabel: TYPO3.l10n.localize('crmpush_accesskey'),
                        name: 'accesskey',
                        allowBlank: false,
                        listeners: {
                            'triggerclick': {
                                scope: this,
                                fn: this.storeValue
                            }
                        }
                    });
                    break;
                case 'module':
                    formItems.push({
                        fieldLabel: TYPO3.l10n.localize('crmpush_module'),
                        name: 'module',
                        allowBlank: false,
                        listeners: {
                            'triggerclick': {
                                scope: this,
                                fn: this.storeValue
                            }
                        }
                    });
                    break;
            }
        }, this);

        formItems.push({
            xtype: 'button',
            text: TYPO3.l10n.localize('button_remove'),
            handler: this.removePostProcessor,
            scope: this
        });

        var config = {
            items: [
                {
                    xtype: 'fieldset',
                    title: TYPO3.l10n.localize('postprocessor_' + this.processor),
                    autoHeight: true,
                    defaults: {
                        width: 165,
                        msgTarget: 'side'
                    },
                    defaultType: 'textfieldsubmit',
                    items: formItems
                }
            ]
        };

        Ext.apply(this, Ext.apply(this.initialConfig, config));

        TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.PostProcessor.superclass.initComponent.apply(this, arguments);

        this.on('clientvalidation', this.validation, this);

        this.on('afterrender', this.newOrExistingPostProcessor, this);
    },

    /**
     * Add the configuration object to this component
     *
     * @param config
     */
    constructor: function(config) {
        Ext.apply(this, {
            configuration: {
                url: '',
                username: '',
                accesskey: '',
                module: ''
            }
        });

        TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.Crmpush.superclass.constructor.apply(this, arguments);
    }
});

Ext.reg('typo3-form-wizard-viewport-left-form-postprocessors-crmpush', TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.Crmpush);