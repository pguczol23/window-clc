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
        data: {
              1: {
                    0: {value: 2907, monvalue: 1200, podvalue: 360, mainimg: "http://window-clc/wp-content/uploads/2020/08/WhatsApp-Image-2020-08-25-at-20.41.15.jpeg"},
                    1: {value: 4751, monvalue: 1200, podvalue: 360, mainimg: "http://window-clc/wp-content/uploads/2020/08/WhatsApp-Image-2020-08-25-at-20.39.33.jpeg"},
                    2: {value: 7113, monvalue: 1600, podvalue: 600, mainimg: "http://window-clc/wp-content/uploads/2020/08/WhatsApp-Image-2020-08-25-at-20.39.49.jpeg"},
                    3: {value: 10210, monvalue: 1800, podvalue: 900, mainimg: "http://window-clc/wp-content/uploads/2020/08/WhatsApp-Image-2020-08-25-at-20.38.27.jpeg"},
                    4: {value: 11433, monvalue: 2000, podvalue: 900, mainimg: "http://window-clc/wp-content/uploads/2020/08/WhatsApp-Image-2020-08-25-at-20.40.34.jpeg"},
              },
              2: {
                   0: {value: 2537, monvalue: 1200, podvalue: 360, mainimg: "http://window-clc/wp-content/uploads/2020/08/WhatsApp-Image-2020-08-25-at-20.41.15.jpeg"},
                   1: {value: 4359, monvalue: 1200, podvalue: 360, mainimg: "http://window-clc/wp-content/uploads/2020/08/WhatsApp-Image-2020-08-25-at-20.39.33.jpeg"},
                   2: {value: 6434, monvalue: 1600, podvalue: 600, mainimg: "http://window-clc/wp-content/uploads/2020/08/WhatsApp-Image-2020-08-25-at-20.39.49.jpeg"},
                   3: {value: 9206, monvalue: 1800, podvalue: 900, mainimg: "http://window-clc/wp-content/uploads/2020/08/WhatsApp-Image-2020-08-25-at-20.38.27.jpeg"},
                   4: {value: 10209, monvalue: 2000, podvalue: 900,mainimg: "http://window-clc/wp-content/uploads/2020/08/WhatsApp-Image-2020-08-25-at-20.40.34.jpeg"},
              }
        },
        onClick: (e) => {
            const self = Calculator;
            const el = $(e.currentTarget);
            self.activeType = self.currentContainer.find(el).index();

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
            let sum = current.value;
            if (self.needMon) {
                sum += current.monvalue;
            }
            if (self.needOtl) {
                sum += current.podvalue;
            }

            self.sumField.html(sum + ' Р.');

            self.maket.attr('src', current.mainimg);
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