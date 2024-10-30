<script type='text/javascript'>
jQuery(document).ready(function ($) {
  var url = '<?php echo plugins_url("proxy.php?callback=?",__FILE__); ?>';
  var slugs = <?php echo json_encode($slugs); ?>;
  var sort_by = '.plugin-name';
  var sort_order = 'asc';

  $('#dashboard_last_plugin_updates a').click(function(e) {
    e.preventDefault();
    var sort_by_new = $(this).data('sortBy');
    if (sort_by == sort_by_new) {
      sort_order = (sort_order == 'asc') ? 'desc' : ((sort_order == 'desc') ? 'asc' : 'desc');
    }

    indicate_sort_order(sort_by_new, sort_by, sort_order);
    sort_by = sort_by_new;
    sort_plugins(sort_by, sort_order);
  });

  var get_data = function(slug) {
    var data = {name: '<?php echo get_bloginfo('name');?>', slug: slug};
    $.ajax({
      url: url,
      type: 'GET',
      data: data,
      success: function (response){
        if (response != null){
          html += '<div class="plugin"><div class="col1 plugin-name" data-sort="'+response.name+'"><a href="http://wordpress.org/extend/plugins/'+response.slug+'" target="_blank">'+response.name+'</a></div><div class="col2 last-update" data-sort="'+response.last_updated+'">'+moment(response.last_updated).format(date_format)+'</div><div class="clear"></div></div>';
        }
        else
          html += not_found(data.slug);
        decrease_counter();
      },
      error: function(res){
        html += not_found(data.slug);
        decrease_counter();
      }
    });
  };

  var decrease_counter = function() {
    --window.Remaining;
    if (window.Remaining == 0) {
      html += ''
      display_plugins();
    }
  }
  var not_found = function(slug) {
    return '<div class="plugin not-found"><div class="col1 plugin-name" data-sort="'+slug+'">'+slug+'</div><div class="col2 last-update" data-sort=""><?php echo __('- no data -', 'lpu');?></div><div class="clear"></div></div>';
  };

  var display_plugins = function() {
    $('#dashboard_last_plugin_updates .loading').remove();
    $('#dashboard_last_plugin_updates .head').removeClass( 'no-display' );
    $('#dashboard_last_plugin_updates .plugins').removeClass( 'no-display' );
    $('#dashboard_last_plugin_updates .plugins').html( html );
    indicate_sort_order(sort_by, sort_by, sort_order);
    sort_plugins(sort_by, sort_order);
  };

  var indicate_sort_order = function(sort_by_new, sort_by_old, sort_order) {
    var direction = ( sort_order == 'desc' ) ? '&#8593;' : '&#8595;';
    $('#dashboard_last_plugin_updates .head ' + sort_by_old + ' p').remove();
    $('#dashboard_last_plugin_updates .head ' + sort_by_new).append('<p>'+ direction + '</p>');
  };

  var sort_plugins = function(sort_by, sort_order) {
    var listEl = $('#dashboard_last_plugin_updates .plugins');
    var plugins = listEl.children('.plugin').get();
    plugins.sort(function(a, b) {
      var aSort = $(a).find(sort_by).data('sort').toLowerCase().replace(/,/,'.');
      var bSort = $(b).find(sort_by).data('sort').toLowerCase().replace(/,/,'.');

      if (isFinite(aSort) && isFinite(bSort)) {
        aSort = +aSort;
        bSort = +bSort;
      }
      if( sort_order == 'asc' ) {
        return aSort > bSort ? 1 : aSort < bSort ? -1 : 0;
      } else if ( sort_order == 'desc') {
        return aSort < bSort ? 1 : aSort > bSort ? -1 : 0;
      }
    });
    listEl.append(plugins);
  };

  var fix_date_format = function(date_format) {
    var fixed_format = "";
    for (var i = 0, len = date_format.length; i < len; i++) {
      var c = date_format[i];
      fixed_format += (c=='d')?('DD'):(
                      (c=='j')?('D'):(
                      (c=='S')?('o'):(
                      (c=='l')?('dddd'):(
                      (c=='D')?('ddd'):(
                      (c=='m')?('MM'):(
                      (c=='n')?('M'):(
                      (c=='F')?('MMMM'):(
                      (c=='M')?('MMM'):(
                      (c=='Y')?('YYYY'):(
                      (c=='y')?('YY'):(c)))))))))));
    }
    return fixed_format;
  };

  var date_format = fix_date_format('<?php echo get_option('date_format');?>');

  window.html = '';
  window.Remaining = slugs.length;

  $.each(slugs, function(_, slug) {
    get_data(slug);
  });

});

</script>