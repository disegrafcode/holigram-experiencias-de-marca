(function () {
    tinymce.create('tinymce.plugins.MyPluginName', {
        init: function (ed, url) {

            /* BOTON 1 */
            ed.addButton('btn_mas_informacion', {
                title: 'Agregar botón "MÁS INFORMACIÓN"',
                cmd: 'btn_mas_informacionCmd',
                image: themeData.themeUrl + '/assets/custom_buttons_tiny/icon-url.gif'
            });

            ed.addCommand('btn_mas_informacionCmd', function () {
                let selectedText = ed.selection.getContent({ format: 'html' });
                let win = ed.windowManager.open({
                    title: 'Botón "MÁS INFORMACIÓN"',
                    body: [
                        {
                            type: 'textbox',
                            name: 'url',
                            label: 'URL',
                            minWidth: 500,
                            value: '',
                            required: true
                        },
                        {
                            type: 'textbox',
                            name: 'link_text',
                            label: 'Link Text',
                            minWidth: 500,
                            value: '',
                            required: true
                        },
                        {
                            type: 'checkbox',
                            name: 'new_tab',
                            label: 'Open link in a new tab',
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
                        let url = e.data.url;
                        let linkText = e.data.link_text;
                        let newTab = e.data.new_tab ? ' target="_blank"' : '';

                        if (url.length === 0 || linkText.length === 0) {
                            alert('URL y Link Text son requeridos.');
                            return;
                        }
                        let returnText = `<a href="${url}" class="btn-pdf btn-more-info" ${newTab}>${linkText}<i class="fa fa-external-link-square"></i></a><br>`;
                        ed.execCommand('mceInsertContent', 0, returnText);
                    }
                });
            });

            /* BOTON 1 */

            /* BOTON 2 */
            ed.addButton('btn_tarjeta_docentes', {
                title: 'Agregar Tarjeta Docentes',
                cmd: 'btn_tarjeta_docentesCmd',
                image: themeData.themeUrl + '/assets/custom_buttons_tiny/icon-url-docentes.gif'
            });

            ed.addCommand('btn_tarjeta_docentesCmd', function () {
                let win = ed.windowManager.open({
                    title: 'Tarjeta Docentes',
                    body: [
                        {
                            type: 'button',
                            name: 'select_image',
                            label: 'Seleccionar Imagen',
                            text: 'Seleccionar Imagen',
                            onclick: function () {
                                var frame = wp.media({
                                    title: 'Seleccionar Imagen',
                                    button: {
                                        text: 'Usar esta imagen'
                                    },
                                    multiple: false
                                });
                                frame.on('select', function () {
                                    var attachment = frame.state().get('selection').first().toJSON();
                                    win.find('#image_url').value(attachment.url);
                                });
                                frame.open();
                            }
                        },
                        {
                            type: 'textbox',
                            name: 'image_url',
                            label: 'URL de la Imagen',
                            id: 'image_url',
                            minWidth: 500,
                            value: '',
                            required: true
                        },
                        {
                            type: 'textbox',
                            name: 'title',
                            label: 'Título',
                            minWidth: 500,
                            value: '',
                            required: true
                        },
                        {
                            type: 'textbox',
                            name: 'description',
                            label: 'Descripción',
                            minWidth: 500,
                            minHeight: 200,
                            value: '',
                            multiline: true,
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
                        let imageUrl = e.data.image_url;
                        let title = e.data.title;
                        let description = e.data.description;

                        if (imageUrl.length === 0 || title.length === 0 || description.length === 0) {
                            alert('Todos los campos son requeridos.');
                            return;
                        }

                        description = description.replace(/\n/g, '<br>');    
                        let returnText = `<div class="card-docente testimonio">
                                <div class="col-xs-4 p-l-o p-r-o career__testimonio__img text-center">
                                <img src="${imageUrl}" alt="${title}" >
                                </div>
                                <div class="col-xs-8 career__testimonio dip gray rltv" style="background-color: #e2e4e7;">
                                <p><strong>${title}</strong></p>
                                <p>${description}</p>
                                </div>
                            </div><br>`;

                        ed.execCommand('mceInsertContent', 0, returnText);
                    }
                });
            });
            /* BOTON 2 */

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
