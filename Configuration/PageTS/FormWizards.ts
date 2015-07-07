mod.wizards {
    form {
        defaults {
            tabs {
                options {
                    showAccordions := addToList(crmfield)
                    accordions {
                        crmfield {
                            showProperties = value
                        }
                    }
                }
                form {
                    accordions {
                        postProcessor {
                            showPostProcessors := addToList(crmpush)
                            postProcessors {
                                crmpush {
                                    showProperties = url, username, accesskey, module
                                }
                            }
                        }
                    }
                }
            }
        }
        elements {
            textarea {
                showAccordions := addToList(crmfield)
            }
            textline {
                showAccordions := addToList(crmfield)
            }
            hidden {
                showAccordions := addToList(crmfield)
            }
            password {
                showAccordions := addToList(crmfield)
            }
            select {
                showAccordions := addToList(crmfield)
            }
            checkbox {
                showAccordions := addToList(crmfield)
            }
            checkboxgroup {
                showAccordions := addToList(crmfield)
            }
            radio < .checkbox
            radiogroup < .checkboxgroup
        }
    }
}