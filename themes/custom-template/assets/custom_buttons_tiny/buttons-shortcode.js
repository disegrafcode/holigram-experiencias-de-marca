(function () {
    tinymce.create('tinymce.plugins.MyPluginName', {
        init: function (ed, url) {

            /* ENCABEZADOS CON COLORES */
            ed.addButton('btn_encabezado', {
                title: 'Agregar Recuadro de Encabezado',
                cmd: 'btn_encabezadoCmd',
                image: themeData.themeUrl + '/assets/custom_buttons_tiny/icon-header.gif'
            });

            ed.addCommand('btn_encabezadoCmd', function () {
                let selectedText = ed.selection.getContent({ format: 'html' });
                if(selectedText.trim()=="")
                {
                    alert('Por favor, seleccione un texto.');
                    return;
                }
                let win = ed.windowManager.open({
                    title: 'Recuadro de Encabezado',
                    body: [
                        {
                            type: 'listbox',
                            name: 'header_type',
                            label: 'Encabezado',
                            values: [
                                { text: 'h1', value: 'h1' },
                                { text: 'h2', value: 'h2' },
                                { text: 'h3', value: 'h3' },
                                { text: 'h4', value: 'h4' },
                                { text: 'h5', value: 'h5' },
                                { text: 'h6', value: 'h6' }
                            ]
                        },
                        {
                            type: 'colorbox',
                            name: 'text_color',
                            label: 'Color de Texto'
                        },
                        {
                            type: 'colorbox',
                            name: 'background_color',
                            label: 'Color de Fondo'
                        },
                        {
                            type: 'textbox',
                            name: 'padding',
                            label: 'Relleno',
                            value: '20px'
                        }
                    ],
                    buttons: [
                        {
                            text: "Ok",
                            subtype: "primary",
                            onclick: function () {
                                win.submit();
                            }
                        },
                        {
                            text: "Cancel",
                            onclick: function () {
                                win.close();
                            }
                        }
                    ],
                    onsubmit: function (e) {
                        let headerType = e.data.header_type;
                        let textColor = e.data.text_color;
                        let backgroundColor = e.data.background_color;
                        let padding = e.data.padding;

                        if (headerType.length === 0) {
                            alert('Encabezado es requerido.');
                            return;
                        }

                        let style = `style="color: ${textColor}; background-color: ${backgroundColor};padding:${padding}"`;
                        let returnText = `<${headerType} ${style}>${selectedText}</${headerType}>`;
                        ed.execCommand('mceInsertContent', 0, returnText);
                    }
                });
            });
            /* ENCABEZADOS CON COLORES */

            /* AGREGAR BOTON BOOTSTRAP */
            ed.addButton('btn_addbutton', {
                title: 'Agregar Botón de Bootstrap',
                cmd: 'btn_addbuttonCmd',
                image: themeData.themeUrl + '/assets/custom_buttons_tiny/icon-add-button.gif'
            });

            ed.addCommand('btn_addbuttonCmd', function () {
                let win = ed.windowManager.open({
                    title: 'Agregar Botón de Bootstrap',
                    body: [
                        {
                            type: 'listbox',
                            name: 'button_bootstrap_type',
                            label: 'Tipo de Botón',
                            values: [
                                { text: 'Primary', value: 'btn-primary' },
                                { text: 'Secondary', value: 'btn-secondary' },
                                { text: 'Success', value: 'btn-success' },
                                { text: 'Danger', value: 'btn-danger' },
                                { text: 'Warning', value: 'btn-warning' },
                                { text: 'Info', value: 'btn-info' },
                                { text: 'Light', value: 'btn-light' },
                                { text: 'Dark', value: 'btn-dark' },
                                { text: 'Link', value: 'btn-link' },
                                { text: 'Outline Primary', value: 'btn-outline-primary' },
                                { text: 'Outline Secondary', value: 'btn-outline-secondary' },
                                { text: 'Outline Success', value: 'btn-outline-success' },
                                { text: 'Outline Danger', value: 'btn-outline-danger' },
                                { text: 'Outline Warning', value: 'btn-outline-warning' },
                                { text: 'Outline Info', value: 'btn-outline-info' },
                                { text: 'Outline Light', value: 'btn-outline-light' },
                                { text: 'Outline Dark', value: 'btn-outline-dark' },
                            ]
                        },
                        {
                            type: 'listbox',
                            name: 'button_bootstrap_size',
                            label: 'Tamaño del botón',
                            values: [
                                { text: 'Tamaño normal', value: '' },
                                { text: 'Grande', value: 'btn-lg' },
                                { text: 'Pequeño', value: 'btn-sm' },
                                { text: '100% de ancho', value: 'w-100' }
                            ]
                        },
                        {
                            type: 'button',
                            name: 'select_image_buton_icon',
                            label: 'Seleccionar Icono',
                            text: 'Seleccionar Icono',
                            onclick: function () {
                                var frame = wp.media({
                                    title: 'Seleccionar Icono',
                                    button: {
                                        text: 'Usar esta imagen'
                                    },
                                    multiple: false
                                });
                                frame.on('select', function () {
                                    var attachment = frame.state().get('selection').first().toJSON();
                                    win.find('#imageicon_url').value(attachment.url);
                                });
                                frame.open();
                            }
                        },
                        {
                            type: 'textbox',
                            name: 'imageicon_url',
                            label: 'URL del icono',
                            id: 'imageicon_url',
                            minWidth: 500,
                            value: '',
                            required: false
                        },
                        {
                            type: 'listbox',
                            name: 'button_bootstrap_image_size',
                            label: 'Tamaño de la imagen',
                            values: [
                                { text: 'Tamaño Original', value: '' },
                                { text: '16x16', value: 'width="16" height="16"' },
                                { text: '18x18', value: 'width="18" height="18"' },
                                { text: '24x24', value: 'width="24" height="24"' },
                                { text: '28x28', value: 'width="28" height="28"' },
                                { text: '32x32', value: 'width="32" height="32"' },
                                { text: '36x36', value: 'width="36" height="36"' },
                                { text: '48x48', value: 'width="48" height="48"' },
                                { text: '60x60', value: 'width="60" height="60"' },
                                { text: '72x72', value: 'width="72" height="72"' }
                            ]
                        },
                        {
                            type: 'textbox',
                            name: 'label_buton',
                            label: 'Etiqueta',
                            minWidth: 500,
                            value: '',
                            required: true
                        },
                        {
                            type: 'textbox',
                            name: 'url_buton',
                            label: 'Enlace URL',
                            minWidth: 500,
                            value: '',
                            required: true
                        }
                    ],
                    buttons: [
                        {
                            text: "Ok",
                            subtype: "primary",
                            onclick: function () {
                                win.submit();
                            }
                        },
                        {
                            text: "Cancel",
                            onclick: function () {
                                win.close();
                            }
                        }
                    ],
                    onsubmit: function (e) {
                        let type_button = e.data.button_bootstrap_type;
                        let button_bootstrap_size =  e.data.button_bootstrap_size;
                        let button_bootstrap_image_size = e.data.button_bootstrap_image_size;
                        let imageicon_url = (e.data.imageicon_url)?`<img src="${e.data.imageicon_url}" ${button_bootstrap_image_size} alt="icono">`:``;
                        let label_buton = e.data.label_buton;
                        let url_buton = e.data.url_buton;
                

                        let returnText = `<a class="btn ${type_button} ${button_bootstrap_size}" href="${url_buton}">${imageicon_url} ${label_buton}</a>`;

                        ed.execCommand('mceInsertContent', 0, returnText);
                    }
                });
            });
            /* AGREGAR BOTON BOOTSTRAP */

            /* AGREGAR BOTON BOOTSTRAP TYPHOGRAPHY */
             ed.addButton('btn_bootstrap_typography', {
                title: 'Agregar Tipografía Bootstrap',
                cmd: 'btn_bootstrap_typographyCmd',
                image: themeData.themeUrl + '/assets/custom_buttons_tiny/icon-typography.gif'
            });

            ed.addCommand('btn_bootstrap_typographyCmd', function () {
                let selectedText = ed.selection.getContent({ format: 'html' });
                if(selectedText.trim()=="")
                {
                    alert('Por favor, seleccione un texto.');
                    return;
                }
                let win = ed.windowManager.open({
                    title: 'Agregar Tipografía Bootstrap',
                    body: [
                        {
                            type: 'listbox',
                            name: 'button_bootstrap_typography',
                            label: 'Tipo de Tipografía',
                            values: [
                                { text: 'Sin formato', value: 'none' },
                                { text: 'Texto destacado', value: 'mark' },
                                { text: 'Texto etiqueta', value: 'label' },
                                { text: 'Texto eliminado', value: 'del' },
                                { text: 'Texto tachado', value: 's' },
                                { text: 'Texto subrayado', value: 'u' },
                                { text: 'Texto pequeño', value: 'small' },
                                { text: 'Parrafo resaltado', value: 'lead' },
                            ]
                        },
                        {
                            type: 'colorbox',
                            name: 'text_color_typography',
                            label: 'Color de Texto',
                            value: '#000000'
                        },
                        {
                            type: 'colorbox',
                            name: 'background_color_typography',
                            label: 'Color de Fondo',
                            value: '#7E7E7E'
                        }
                    ],
                    buttons: [
                        {
                            text: "Ok",
                            subtype: "primary",
                            onclick: function () {
                                win.submit();
                            }
                        },
                        {
                            text: "Cancel",
                            onclick: function () {
                                win.close();
                            }
                        }
                    ],
                    onsubmit: function (e) {
                        let button_bootstrap_typography = e.data.button_bootstrap_typography;
                        let text_color_typography = e.data.text_color_typography;
                        let background_color_typography = e.data.background_color_typography;
                        let typography_style = '';
                        let return_text="";
                        /* STYLE */
                        if (background_color_typography || background_color_typography !== "")
                        {
                            typography_style=`background-color:${background_color_typography};`;
                        }
                        if (text_color_typography || text_color_typography !== "")
                        {
                            typography_style+=`color:${text_color_typography};`;
                        }
                        typography_style=`style="${typography_style}"`;
                        /* STYLE */
                        switch(button_bootstrap_typography)
                        {
                            case "none":
                                return_text=`<p>${selectedText}</p>`;
                            break;
                            case "label":
                                return_text=`<span class="badge fs-6" ${typography_style}>${selectedText}</span>`;
                            break;
                            case "mark":
                                return_text=`<mark ${typography_style}>${selectedText}</mark>`;
                            break;
                            case "del":
                                return_text=`<del ${typography_style}>${selectedText}</del>`;
                            break;
                            case "s":
                                return_text=`<s ${typography_style}>${selectedText}</s>`;
                            break;
                            case "u":
                                return_text=`<u ${typography_style}>${selectedText}</u>`;
                            break;
                            case "small":
                                return_text=`<small ${typography_style}>${selectedText}</small>`;
                            break;
                            case "lead":
                                return_text=`<p class="lead" ${typography_style}>${selectedText}</p>`;
                            break;
                        }
                        ed.execCommand('mceInsertContent', 0, return_text);    
                    }
                });
            });
            /* AGREGAR BOTON BOOTSTRAP TYPHOGRAPHY */

            /* AGREGAR BOTON SHORCODE IMAGEN / TEXTO */
            ed.addButton('btn_imagen_texto', {
                title: 'Agregar imagen y texto',
                cmd: 'btn_imagen_textoCmd',
                image: themeData.themeUrl + '/assets/custom_buttons_tiny/icon-image-texto.gif'
            });
            ed.addCommand('btn_imagen_textoCmd', function () {
                let win = ed.windowManager.open({
                    title: 'Agregar imagen y texto',
                    body: [
                        {
                            type: 'textbox',
                            name: 'imagen_texto_etiqueta',
                            label: 'Etiqueta',
                            value: '',
                            required: true
                        },
                        {
                            type: 'listbox',
                            name: 'imagen_texto_label',
                            label: 'Tipo de Botón',
                            values: [
                                { text: 'Parrafo', value: 'p' },
                                { text: 'Span', value: 'span' },
                                { text: 'Bold', value: 'strong' },
                                { text: 'H1', value: 'h1' },
                                { text: 'H2', value: 'h2' },
                                { text: 'H3', value: 'h3' },
                                { text: 'H4', value: 'h4' },
                                { text: 'H5', value: 'h5' },
                                { text: 'H6', value: 'h6' },
                            ]
                        },
                        {
                            type: 'button',
                            name: 'select_imagen_texto',
                            label: 'Seleccionar Icono',
                            text: 'Seleccionar Icono',
                            onclick: function () {
                                var frame = wp.media({
                                    title: 'Seleccionar Icono',
                                    button: {
                                        text: 'Usar esta imagen'
                                    },
                                    multiple: false
                                });
                                frame.on('select', function () {
                                    var attachment = frame.state().get('selection').first().toJSON();
                                    win.find('#imagen_texto_url_image').value(attachment.url);
                                });
                                frame.open();
                            }
                        },
                        {
                            type: 'textbox',
                            name: 'imagen_texto_url_image',
                            label: 'URL del icono',
                            id: 'imagen_texto_url_image',
                            minWidth: 500,
                            value: '',
                            required: false
                        },
                        {
                            type: 'listbox',
                            name: 'imagen_texto_image_size',
                            label: 'Tamaño de la imagen',
                            values: [
                                { text: 'Tamaño Original', value: '' },
                                { text: '16x16', value: '16px' },
                                { text: '18x18', value: '18px' },
                                { text: '24x24', value: '24px' },
                                { text: '28x28', value: '28px' },
                                { text: '32x32', value: '32px' },
                                { text: '36x36', value: '36px' },
                                { text: '48x48', value: '48px' },
                                { text: '60x60', value: '60px' },
                                { text: '72x72', value: '72px' }
                            ]
                        },
                        {
                            type: 'colorbox',
                            name: 'imagen_texto_text_color',
                            label: 'Color de Texto'
                        }
                    ],
                    buttons: [
                        {
                            text: "Ok",
                            subtype: "primary",
                            onclick: function () {
                                win.submit();
                            }
                        },
                        {
                            text: "Cancel",
                            onclick: function () {
                                win.close();
                            }
                        }
                    ],
                    onsubmit: function (e) {
                        let imagen_texto_label = e.data.imagen_texto_label;
                        let imagen_texto_etiqueta = e.data.imagen_texto_etiqueta;
                        let imagen_texto_url_image = e.data.imagen_texto_url_image;
                        let imagen_texto_image_size = e.data.imagen_texto_image_size;
                        let imagen_texto_text_color = e.data.imagen_texto_text_color;
                

                        let returnText = `[imagen_con_texto
                                            etiqueta="${imagen_texto_label}"
                                            image="${imagen_texto_url_image}"
                                            size="${imagen_texto_image_size}"
                                            color="${imagen_texto_text_color}"]
                                          ${imagen_texto_etiqueta}  
                                          [/imagen_con_texto]`;

                        ed.execCommand('mceInsertContent', 0, returnText);
                    }
                });
            });
            /* AGREGAR BOTON SHORCODE IMAGEN / TEXTO */

        },
        getInfo: function () {
            return {
                longname: 'Isil Custom Buttons',
                author: 'Cesar A.',
                authorurl: 'https://isil.pe/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('mytinymceplugin', tinymce.plugins.MyPluginName);
})();
