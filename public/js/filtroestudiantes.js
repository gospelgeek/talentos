 var filtersConfig = {
        base_path: '/tablefilter/',
        col_number_format: [null,null,'US','US','US'],  
        col_0: 'select', 
        col_1: 'select',
        col_8: 'disabled',
        display_all_text: "<SELECCIONAR>", 
        
         paging: {
          results_per_page: ['Records: ', [50,200,500]]
        },
        alternate_rows: true,
        rows_counter: true,
        btn_reset: true,
        loader: true,
        status_bar: true,
        mark_active_columns: {
            highlight_column: true
        },
        highlight_keywords: true,
        no_results_message: true,
        

        extensions:[{ name: 'sort' }],
         filters_cell_tag: 'th',



        // allows Material Design Lite table styling
        themes: [{
            name: 'transparent'
        }]
    };

    var tf = new TableFilter('table9', filtersConfig);
    tf.init();