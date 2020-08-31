jQuery(function($){

    let Calculator = {
        type: 1,
        sumField: $('.form-container .bl_left span'),
        optionsEls: $('.form-container .oc_line .checkbox input'),
        typesContainerEls: $(".base-container .type-container"),
        currentContainer: null,
        typesWindow: $(".window-menu .type-window"),
        currentTypes: null,
        activeType: null,
        needOtl: false,
        needMon: false,
        maket: $('.form-container .maket img'),
        data: {"1":[{"value":"2907","monvalue":"1200","podvalue":"360","mainimg":"http:\/\/window-clc\/wp-content\/uploads\/2020\/08\/WhatsApp-Image-2020-08-25-at-20.41.15.jpeg","alt":"\u0413\u043b\u0443\u0445\u043e\u0435 700*1400"},{"value":"4751","monvalue":"1200","podvalue":"360","mainimg":"http:\/\/window-clc\/wp-content\/uploads\/2020\/08\/WhatsApp-Image-2020-08-25-at-20.39.33.jpeg","alt":"\u041e\u0434\u043d\u043e\u0441\u0442\u0432\u043e\u0440\u0447\u0430\u0442\u043e\u0435 700*1400"},{"value":"7113","monvalue":"1600","podvalue":"600","mainimg":"http:\/\/window-clc\/wp-content\/uploads\/2020\/08\/WhatsApp-Image-2020-08-25-at-20.39.49.jpeg","alt":"\u0414\u0432\u0443\u0445\u0441\u0442\u0432\u043e\u0440\u0447\u0430\u0442\u043e\u0435 1300*1400"},{"value":"10210","monvalue":"1800","podvalue":"900","mainimg":"http:\/\/window-clc\/wp-content\/uploads\/2020\/08\/WhatsApp-Image-2020-08-25-at-20.38.27.jpeg","alt":"\u0422\u0440\u0435\u0445\u0441\u0442\u0432\u043e\u0440\u0447\u0430\u0442\u043e\u0435 2100*1400"},{"value":"11433","monvalue":"2000","podvalue":"900","mainimg":"http:\/\/window-clc\/wp-content\/uploads\/2020\/08\/WhatsApp-Image-2020-08-25-at-20.40.34.jpeg","alt":"\u0411\u0430\u043b\u043a\u043e\u043d\u043d\u044b\u0439 \u0431\u043b\u043e\u043a. \u041e\u043a\u043d\u043e 1300*1400. \u0414\u0432\u0435\u0440\u044c 700*200"}],"2":[{"value":"2537","monvalue":"1200","podvalue":"360","mainimg":"http:\/\/window-clc\/wp-content\/uploads\/2020\/08\/WhatsApp-Image-2020-08-25-at-20.41.15.jpeg","alt":"\u0413\u043b\u0443\u0445\u043e\u0435 700*1400"},{"value":"4359","monvalue":"1200","podvalue":"360","mainimg":"http:\/\/window-clc\/wp-content\/uploads\/2020\/08\/WhatsApp-Image-2020-08-25-at-20.39.33.jpeg","alt":"\u041e\u0434\u043d\u043e\u0441\u0442\u0432\u043e\u0440\u0447\u0430\u0442\u043e\u0435 700*1400"},{"value":"6434","monvalue":"1600","podvalue":"600","mainimg":"http:\/\/window-clc\/wp-content\/uploads\/2020\/08\/WhatsApp-Image-2020-08-25-at-20.39.49.jpeg","alt":"\u0414\u0432\u0443\u0445\u0441\u0442\u0432\u043e\u0440\u0447\u0430\u0442\u043e\u0435 1300*1400"},{"value":"9206","monvalue":"1800","podvalue":"900","mainimg":"http:\/\/window-clc\/wp-content\/uploads\/2020\/08\/WhatsApp-Image-2020-08-25-at-20.38.27.jpeg","alt":"\u0422\u0440\u0435\u0445\u0441\u0442\u0432\u043e\u0440\u0447\u0430\u0442\u043e\u0435 2100*1400"},{"value":"10209","monvalue":"2000","podvalue":"900","mainimg":"http:\/\/window-clc\/wp-content\/uploads\/2020\/08\/WhatsApp-Image-2020-08-25-at-20.40.34.jpeg","alt":"\u0411\u0430\u043b\u043a\u043e\u043d\u043d\u044b\u0439 \u0431\u043b\u043e\u043a. \u041e\u043a\u043d\u043e 1300*1400. \u0414\u0432\u0435\u0440\u044c 700*200"}]},
        onClick: (e) => {
            const self = Calculator;
            const el = $(e.currentTarget);
            const index = self.currentContainer.find(el).index();

            if (index === self.activeType) {
                return;
            }

            self.activeType = index;

            self.calculate();
        },
        onChange: (e) => {
            const self = Calculator;

            const el = $(e.target)[0];

            if (el.name === 'need_otliv') {
                self.needOtl = $(el).prop('checked');
            }else {
                self.needMon = $(el).prop('checked');
            }

            self.calculate();
        },
        calculate: () => {
            const self = Calculator;

            self.typesContainerEls.hide();
            self.currentContainer = $(self.typesContainerEls[self.type-1]);
            self.currentContainer.show();

            self.currentTypes = self.currentContainer.find('.window-menu .type-window');
            self.typesWindow.unbind('click');
            self.currentTypes.on('click', self.onClick);

            self.typesWindow.removeClass('active');

            const index = self.activeType;

            $(self.currentTypes[index]).addClass('active');

            let current = self.data[self.type][index];
            let sum = Number(current.value);
            if (self.needMon) {
                sum += Number(current.monvalue);
            }
            if (self.needOtl) {
                sum += Number(current.podvalue);
            }

            self.sumField.html(sum + ' Р.');

            self.maket.attr('src', current.mainimg);
            self.maket.attr('alt', current.alt);
        },
        init: () => {
            const self = Calculator;

            let radio = $(".choose-view .radio input");

            radio.on('change', (e) => {
                Calculator.type = Number($(e.target).val());
                Calculator.calculate();
            });

            self.optionsEls.on('change', self.onChange);

            self.activeType = 0;

            self.calculate();
        }
    };

    window.Calculator = Calculator;
    Calculator.init();
});