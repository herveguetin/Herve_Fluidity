/**
 * @category    Herve
 * @package     Herve_Fluidity
 * @copyright   Copyright (c) 2013 Hervé Guétin (http://www.herveguetin.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/**
 * Override some prototype validation.js methods in order to use Foundation form errors classes
 */
Object.extend(Validation, {
    test : function(name, elm, useTitle) {
        var v = Validation.get(name);
        var prop = '__advice'+name.camelize();
        try {
            if(Validation.isVisible(elm) && !v.test($F(elm), elm)) {
                //if(!elm[prop]) {
                var advice = Validation.getAdvice(name, elm);
                if (advice == null) {
                    advice = this.createAdvice(name, elm, useTitle);
                }
                this.showAdvice(elm, advice, name);
                this.updateCallback(elm, 'failed');
                //}
                elm[prop] = 1;
                if (!elm.advaiceContainer) {
                    elm.removeClassName('validation-passed');
                    elm.addClassName('validation-failed error');
                }

                if (Validation.defaultOptions.addClassNameToContainer && Validation.defaultOptions.containerClassName != '') {
                    var container = elm.up(Validation.defaultOptions.containerClassName);
                    if (container && this.allowContainerClassName(elm)) {
                        container.removeClassName('validation-passed');
                        container.addClassName('validation-error error');
                    }
                }
                return false;
            } else {
                var advice = Validation.getAdvice(name, elm);
                this.hideAdvice(elm, advice);
                this.updateCallback(elm, 'passed');
                elm[prop] = '';
                elm.removeClassName('validation-failed error');
                elm.addClassName('validation-passed');
                if (Validation.defaultOptions.addClassNameToContainer && Validation.defaultOptions.containerClassName != '') {
                    var container = elm.up(Validation.defaultOptions.containerClassName);
                    if (container && !container.down('.validation-failed') && this.allowContainerClassName(elm)) {
                        if (!Validation.get('IsEmpty').test(elm.value) || !this.isVisible(elm)) {
                            container.addClassName('validation-passed');
                        } else {
                            container.removeClassName('validation-passed');
                        }
                        container.removeClassName('validation-error error');
                    }
                }
                return true;
            }
        } catch(e) {
            throw(e)
        }
    },

    createAdvice : function(name, elm, useTitle, customError) {
        var v = Validation.get(name);
        var errorMsg = useTitle ? ((elm && elm.title) ? elm.title : v.error) : v.error;
        if (customError) {
            errorMsg = customError;
        }
        try {
            if (Translator){
                errorMsg = Translator.translate(errorMsg);
            }
        }
        catch(e){}

        advice = '<small class="error validation-advice" id="advice-' + name + '-' + Validation.getElmID(elm) +'" style="display:none">' + errorMsg + '</small>'


        Validation.insertAdvice(elm, advice);
        advice = Validation.getAdvice(name, elm);
        if($(elm).hasClassName('absolute-advice')) {
            var dimensions = $(elm).getDimensions();
            var originalPosition = Position.cumulativeOffset(elm);

            advice._adviceTop = (originalPosition[1] + dimensions.height) + 'px';
            advice._adviceLeft = (originalPosition[0])  + 'px';
            advice._adviceWidth = (dimensions.width)  + 'px';
            advice._adviceAbsolutize = true;
        }
        return advice;
    }
});