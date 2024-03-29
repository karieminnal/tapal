// https://stackoverflow.com/questions/13261970/how-to-get-the-absolute-path-of-the-current-javascript-file-name/13262027#13262027
// Untuk mendapatkan base_url, karena aplikasi bisa terinstall di subfolder
var scripts = document.getElementsByTagName('script');
var last_script = scripts[scripts.length - 1];
var file_ini = last_script.src;
// Harus mengetahui lokasi & nama file script ini
var base_url = file_ini.replace('assets/js/script.js', '');

$(window).on('load', function () {
  // Scroll ke menu aktif perlu dilakukan di onload sesudah semua loading halaman selesai
  // Tidak bisa di document.ready
  // preparing var for scroll via query selector
  var activated_menu = $('li.treeview.active.menu-open')[0];
  // autscroll to activated menu/sub menu
  if (activated_menu) {
    activated_menu.scrollIntoView({ behavior: 'smooth' });
  }
  $('#pilihDesa').select2({
    placeholder: 'Pilih Desa',
    language: 'id',
    width: '100%',
  });
  $('#pilihProvinsi').select2({
    placeholder: 'Pilih Provinsi',
    language: 'id',
    width: '100%',
  });
  $('#pilihKota').select2({
    placeholder: 'Pilih Kota/Kabupaten',
    language: 'id',
    width: '100%',
  });
  $('#pilihKecamatan').select2({
    placeholder: 'Pilih Kecamatan',
    language: 'id',
    width: '100%',
  });
  $('#pilihKelurahan').select2({
    placeholder: 'Pilih Kelurahan',
    language: 'id',
    width: '100%',
  });
  $('#pilihProvinsi, #pilihKota, #pilihKecamatan, #pilihKelurahan').on(
    'select2:open',
    function (e) {
      $('body').addClass('select-open');
    },
  );
  $('#pilihProvinsi, #pilihKota, #pilihKecamatan, #pilihKelurahan').on(
    'select2:close',
    function (e) {
      $('body').removeClass('select-open');
    },
  );
  $('#pilihProvinsi').change(function () {
    $('img#load1').show();
    var id_provinces = $(this).val();
    var name_provinces = $(this).find(':selected').data('name');
    $.ajax({
      type: 'POST',
      dataType: 'html',
      url: '/first/getProvinsi?jenis=kota',
      data: 'id_provinces=' + id_provinces,
      success: function (msg) {
        $('select#pilihKota').html(msg);
        $('img#load1').hide();
        $('.row-kota').addClass('show');
        var inputKodeProv = $('.clone-input input[name=kode_propinsi]');
        if ($(inputKodeProv).length) {
          $(inputKodeProv).val(id_provinces);
        }

        var inputNamaProv = $('.clone-input input[name=nama_propinsi]');
        // name_provinces = name_provinces
        //   .toLowerCase()
        //   .replace(/\b[a-z]/g, function (letter) {
        //     return letter.toUpperCase();
        //   });
        if ($(inputNamaProv).length) {
          $(inputNamaProv).val(name_provinces);
        }
        getAjaxKota();
      },
    });
  });

  $('#pilihKota').change(getAjaxKota);
  function getAjaxKota() {
    $('img#load2').show();
    var id_regencies = $('#pilihKota').val();
    var name_regencies = $('#pilihKota').find(':selected').data('name');
    $.ajax({
      type: 'POST',
      dataType: 'html',
      url: '/first/getProvinsi?jenis=kecamatan',
      data: 'id_regencies=' + id_regencies,
      success: function (msg) {
        $('select#pilihKecamatan').html(msg);
        $('img#load2').hide();
        $('.row-kecamatan').addClass('show');
        var inputKodeKab = $('.clone-input input[name=kode_kabupaten]');
        if ($(inputKodeKab).length) {
          $(inputKodeKab).val(id_regencies);
        }
        var inputNamaKab = $('.clone-input input[name=nama_kabupaten]');
        if ($(inputNamaKab).length) {
          $(inputNamaKab).val(name_regencies);
        }
        getAjaxKecamatan();
      },
    });
  }

  $('#pilihKecamatan').change(getAjaxKecamatan);
  function getAjaxKecamatan() {
    $('img#load3').show();
    var id_district = $('#pilihKecamatan').val();
    var name_district = $('#pilihKecamatan').find(':selected').data('name');
    $.ajax({
      type: 'POST',
      dataType: 'html',
      url: '/first/getProvinsi?jenis=kelurahan',
      data: 'id_district=' + id_district,
      success: function (msg) {
        $('select#pilihKelurahan').html(msg);
        $('img#load3').hide();
        $('.row-desa').addClass('show');
        var inputKodeKec = $('.clone-input input[name=kode_kecamatan]');
        if ($(inputKodeKec).length) {
          $(inputKodeKec).val(id_district);
        }
        var inputNamaKec = $('.clone-input input[name=nama_kecamatan]');
        if ($(inputNamaKec).length) {
          $(inputNamaKec).val(name_district);
        }
        getAjaxKelurahan();
      },
    });
  }

  $('#pilihKelurahan').change(getAjaxKelurahan);
  function getAjaxKelurahan() {
    var id_desa = $('#pilihKelurahan').val();
    var name_desa = $('#pilihKelurahan').find(':selected').data('name');
    var inputKodeDesa = $('.clone-input input[name=kode_desa]');
    if ($(inputKodeDesa).length) {
      $(inputKodeDesa).val(id_desa);
    }
    var inputNamaDesa = $('.clone-input input[name=nama_desa]');
    if ($(inputNamaDesa).length) {
      $(inputNamaDesa).val(name_desa);
    }
  }
});

$(function () {
  var tablePersil = $('#tablePersilList');
  if (tablePersil.length) {
    var tablePersil = $('#tablePersilList').DataTable({
      columnDefs: [
        {
          targets: 'no-sort',
          orderable: false,
        },
        {
          targets: 6,
          render: $.fn.dataTable.render.number(',', '.', 0, ''),
        },
        {
          targets: 7,
          render: $.fn.dataTable.render.number(',', '.', 0, ''),
        },
      ],
      pageLength: 100,
      language: {
        decimal: '.',
        thousands: ',',
        lengthMenu: 'Tampilkan _MENU_ data perhalaman',
        zeroRecords: 'Data tidak ditemukan',
        info: '_START_ - _END_ dari _TOTAL_ data',
        infoEmpty: 'Data tidak ditemukan',
        infoFiltered: '(filtered from _MAX_ total records)',
        sSearch: 'Cari:',
        oPaginate: {
          sFirst: 'Awal',
          sLast: 'Akhir',
          sNext: '>',
          sPrevious: '<',
        },
      },
      drawCallback: function (settings) {
        $('[data-toggle="tooltip"]').tooltip();
      },
      formatNumber: function (toFormat) {
        return toFormat.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      },
      initComplete: function (settings, json) {
        $('[data-toggle="tooltip"]').tooltip();
        $('.loading-data').fadeOut('slow');
      },
    });
    tablePersil
      .on('order.dt search.dt', function () {
        tablePersil
          .column(0, {
            search: 'applied',
            order: 'applied',
          })
          .nodes()
          .each(function (cell, i) {
            cell.innerHTML = i + 1;
          });
        $('[data-toggle="tooltip"]').tooltip();
      })
      .draw();
  }

  var tablePanen = $('#tablePanenList');
  if (tablePanen.length) {
    var tablePanen = $('#tablePanenList').DataTable({
      columnDefs: [
        {
          targets: 'no-sort',
          orderable: false,
        },
        // {
        //   targets: 4,
        //   render: $.fn.dataTable.render.number(',', '.', 0, ''),
        // },
        // {
        //   targets: 7,
        //   render: $.fn.dataTable.render.number(',', '.', 0, ''),
        // },
      ],
      pageLength: 100,
      language: {
        decimal: '.',
        thousands: ',',
        lengthMenu: 'Tampilkan _MENU_ data perhalaman',
        zeroRecords: 'Data tidak ditemukan',
        info: '_START_ - _END_ dari _TOTAL_ data',
        infoEmpty: 'Data tidak ditemukan',
        infoFiltered: '(filtered from _MAX_ total records)',
        sSearch: 'Cari:',
        oPaginate: {
          sFirst: 'Awal',
          sLast: 'Akhir',
          sNext: '>',
          sPrevious: '<',
        },
      },
      drawCallback: function (settings) {
        $('[data-toggle="tooltip"]').tooltip();
      },
      formatNumber: function (toFormat) {
        return toFormat.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      },
      initComplete: function (settings, json) {
        $('[data-toggle="tooltip"]').tooltip();
        $('.loading-data').fadeOut('slow');
      },
    });
    tablePanen
      .on('order.dt search.dt', function () {
        tablePanen
          .column(0, {
            search: 'applied',
            order: 'applied',
          })
          .nodes()
          .each(function (cell, i) {
            cell.innerHTML = i + 1;
          });
        $('[data-toggle="tooltip"]').tooltip();
      })
      .draw();
  }

  var collapsedGroups = {};
  var top = '';
  var parent = '';
  var groupColumn = 0;
  var table = $('#tableListDesa').DataTable({
    displayLength: 50,
    order: [
      [0, 'asc'],
      [1, 'asc'],
    ],
    rowGroup: {
      dataSrc: [0, 1],
      startRender: function (rows, group, level) {
        var all;

        if (level === 0) {
          top = group;
          all = group;
        } else {
          // if parent collapsed, nothing to do
          if (!!collapsedGroups[top]) {
            return;
          }
          all = top + group;
        }

        var collapsed = !!collapsedGroups[all];

        rows.nodes().each(function (r) {
          r.style.display = collapsed ? 'none' : '';
        });

        // Add category name to the <tr>. NOTE: Hardcoded colspan
        return $('<tr/>')
          .append('<th colspan="7">' + group + ' (' + rows.count() + ')</th>')
          .attr('data-name', all)
          .toggleClass('collapsed', collapsed);
      },
    },
    columnDefs: [
      {
        visible: false,
        targets: [0, 1],
      },
      {
        targets: 'no-sort',
        orderable: false,
      },
    ],
    // order: [[groupColumn, 'asc']],
    // displayLength: 25,
    // drawCallback: function (settings) {
    //   var api = this.api();
    //   var rows = api.rows({ page: 'current' }).nodes();
    //   var last = null;

    //   api
    //     .column(groupColumn, { page: 'current' })
    //     .data()
    //     .each(function (group, i) {
    //       if (last !== group) {
    //         $(rows)
    //           .eq(i)
    //           .before(
    //             '<tr class="group"><td colspan="10">' + group + '</td></tr>',
    //           );

    //         last = group;
    //       }
    //     });
    // },
  });
  $('#tableListDesa tbody').on('click', 'tr.dtrg-start', function () {
    var name = $(this).data('name');
    collapsedGroups[name] = !collapsedGroups[name];
    table.draw(false);
  });
  // Order by the grouping
  //   $('#tableListDesa tbody').on('click', 'tr.group', function () {
  //     var currentOrder = table.order()[0];
  //     if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
  //       table.order([groupColumn, 'desc']).draw();
  //     } else {
  //       table.order([groupColumn, 'asc']).draw();
  //     }
  //   });

  var getIframe = $('.iframe-view');
  if (getIframe.length) {
    $(getIframe).each(function () {
      var thisClass = $(this);
      thisClass.iframeAutoHeight({
        minHeight: 240, // Sets the iframe height to this value if the calculated value is less
        heightOffset: 50, // Optionally add some buffer to the bottom
      });
    });
  }
});

var isTimeout;
var isLoaded;

function successLoadIframe() {
  if (isTimeout) {
    return;
  }
  $('.loading-iframe').hide();
  $('.iframe-view').each(function () {
    $(this).addClass('visible');
  });
  isLoaded = true;
}

setTimeout(function () {
  if (isLoaded) {
    return;
  }
  $('.loading-iframe').hide();
  //   $('.iframe-view').removeClass('visible');
  $('.iframe-view').each(function () {
    $(this).removeClass('visible');
  });
  $('.error-iframe').addClass('visible');
  isTimeout = true;
}, 5000);
$(document).ready(function () {
  //CheckBox All Selected
  checkAll();
  $("input[name='id_cb[]'").click(function () {
    enableHapusTerpilih();
  });
  enableHapusTerpilih();

  //Display Modal Box
  modalBox();

  //Display MAP Box
  mapBox();

  //Confirm Delete Modal
  $('#confirm-delete').on('show.bs.modal', function (e) {
    var string = document.getElementById('confirm-delete').innerHTML;
    var hasil = string.replace(
      'fa fa-text-width text-yellow',
      'fa fa-exclamation-triangle text-red',
    );
    document.getElementById('confirm-delete').innerHTML = hasil;

    var string2 = document.getElementById('confirm-delete').innerHTML;
    var hasil2 = string2.replace('Konfirmasi', '&nbspKonfirmasi');
    document.getElementById('confirm-delete').innerHTML = hasil2;
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });

  $('#confirm-status').on('show.bs.modal', function (e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
  //Delay Alert
  setTimeout(function () {
    $('#notification').fadeIn('slow');
  }, 500);
  setTimeout(function () {
    $('#notification').fadeOut('slow');
  }, 2000);

  // Select2 dengan fitur pencarian
  $('.select2').select2();

  $('.pilihDesaHeader').select2({
    dropdownAutoWidth: true,
  });

  $('.select2-nik-ajax').select2({
    ajax: {
      url: function () {
        return $(this).data('url');
      },
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          q: params.term || '', // search term
          page: params.page || 1,
          filter_sex: $(this).data('filter-sex'),
        };
      },
      processResults: function (data, params) {
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        // params.page = params.page || 1;

        return {
          results: data.results,
          pagination: data.pagination,
        };
      },
      cache: true,
    },
    templateResult: function (penduduk) {
      if (!penduduk.id) {
        return penduduk.text;
      }
      var _tmpPenduduk = penduduk.text.split('\n');
      var $penduduk = $(
        '<div>' + _tmpPenduduk[0] + '</div><div>' + _tmpPenduduk[1] + '</div>',
      );
      return $penduduk;
    },
    placeholder: '--  Cari NIK / Tag ID Card / Nama Penduduk --',
    minimumInputLength: 0,
  });

  $('.select2-nik').select2({
    templateResult: function (penduduk) {
      if (!penduduk.id) {
        return penduduk.text;
      }
      var _tmpPenduduk = penduduk.text.split('\n');
      var $penduduk = $(
        '<div>' + _tmpPenduduk[0] + '</div><div>' + _tmpPenduduk[1] + '</div>',
      );
      return $penduduk;
    },
  });

  // Select2 menampilkan ikon
  // https://stackoverflow.com/questions/37386293/how-to-add-icon-in-select2
  function format_ikon(state) {
    if (!state.id) {
      return state.text;
    }
    return (
      '<i class="fa fa-lg ' +
      state.id.toLowerCase() +
      '"></i>&nbsp;&nbsp; ' +
      state.text
    );
  }
  $('.select2-ikon').select2({
    templateResult: format_ikon,
    templateSelection: format_ikon,
    escapeMarkup: function (m) {
      return m;
    },
  });

  // Select2 dengan fitur pencarian dan boleh isi sendiri
  $('.select2-tags').select2({
    tags: true,
  });
  // Select2 untuk disposisi pada form
  // surat masuk
  $('#disposisi_kepada').select2({
    placeholder: 'Pilih tujuan disposisi',
  });

  // Reset select2 ke nilai asli
  // https://stackoverflow.com/questions/10319289/how-to-execute-code-after-html-form-reset-with-jquery
  $('button[type="reset"]').click(function (e) {
    e.preventDefault();
    $(this).closest('form').get(0).reset();
    // https://stackoverflow.com/questions/15205262/resetting-select2-value-in-dropdown-with-reset-button
    $('.select2').trigger('change');
    $('.select2-ikon').trigger('change');
  });

  //File Upload
  $('#file_browser').click(function (e) {
    e.preventDefault();
    $('#file').click();
  });
  $('#file').change(function () {
    $('#file_path').val($(this).val());
    if ($(this).val() == '') {
      $('#' + $(this).data('submit')).attr('disabled', 'disabled');
    } else {
      $('#' + $(this).data('submit')).removeAttr('disabled');
    }
  });
  $('#file_browser_pano').click(function (e) {
    e.preventDefault();
    $('#file_pano').click();
  });
  $('#file_pano').change(function () {
    $('#file_path_pano').val($(this).val());
    if ($(this).val() == '') {
      $('#' + $(this).data('submit')).attr('disabled', 'disabled');
    } else {
      $('#' + $(this).data('submit')).removeAttr('disabled');
    }
  });

  $('#file_path').click(function () {
    $('#file_browser').click();
  });

  $('#file_path_pano').click(function () {
    $('#file_browser_pano').click();
  });

  $('#file_browser1').click(function (e) {
    e.preventDefault();
    $('#file1').click();
  });
  $('#file1').change(function () {
    $('#file_path1').val($(this).val());
  });
  $('#file_path1').click(function () {
    $('#file_browser1').click();
  });

  $('#file_browser2').click(function (e) {
    e.preventDefault();
    $('#file2').click();
  });
  $('#file2').change(function () {
    $('#file_path2').val($(this).val());
  });
  $('#file_path2').click(function () {
    $('#file_browser2').click();
  });

  $('#file_browser3').click(function (e) {
    e.preventDefault();
    $('#file3').click();
  });
  $('#file3').change(function () {
    $('#file_path3').val($(this).val());
  });
  $('#file_path3').click(function () {
    $('#file_browser3').click();
  });

  $('#file_browser4').click(function (e) {
    e.preventDefault();
    $('#file4').click();
  });
  $('#file4').change(function () {
    $('#file_path4').val($(this).val());
  });
  $('#file_path4').click(function () {
    $('#file_browser4').click();
  });
  //Fortmat Tanggal dan Jam
  $('.datepicker').datepicker({
    weekStart: 1,
    language: 'id',
    format: 'dd-mm-yyyy',
    autoclose: true,
  });
  $('#tgl_mulai').datetimepicker({
    locale: 'id',
    format: 'DD-MM-YYYY',
    useCurrent: false,
    date: moment(new Date()),
  });
  $('#tgl_akhir').datetimepicker({
    locale: 'id',
    format: 'DD-MM-YYYY',
    useCurrent: false,
    minDate: moment(new Date()).add(-1, 'day'), // Todo: mengapa harus dikurangi -- bug?
    date: moment(new Date()).add(1, 'M'),
  });
  $('#tgl_mulai')
    .datetimepicker()
    .on('dp.change', function (e) {
      $('#tgl_akhir')
        .data('DateTimePicker')
        .minDate(moment(new Date(e.date)));
      $(this).data('DateTimePicker').hide();
      var tglAkhir = moment(new Date(e.date));
      tglAkhir.add(1, 'M');
      $('#tgl_akhir').data('DateTimePicker').date(tglAkhir);
    });

  $('#tgljam_mulai').datetimepicker({
    locale: 'id',
    format: 'DD-MM-YYYY HH:mm',
    useCurrent: false,
    date: moment(new Date()),
    sideBySide: true,
  });
  $('#tgljam_akhir').datetimepicker({
    locale: 'id',
    format: 'DD-MM-YYYY HH:mm',
    useCurrent: false,
    minDate: moment(new Date()).add(-1, 'day'), // Todo: mengapa harus dikurangi -- bug?
    date: moment(new Date()).add(1, 'day'),
    sideBySide: true,
  });
  $('#tgljam_mulai')
    .datetimepicker()
    .on('dp.change', function (e) {
      $('#tgljam_akhir')
        .data('DateTimePicker')
        .minDate(moment(new Date(e.date)));
      var tglAkhir = moment(new Date(e.date));
      tglAkhir.add(1, 'day');
      $('#tgljam_akhir').data('DateTimePicker').date(tglAkhir);
    });

  $('.tgl_jam').datetimepicker({
    format: 'DD-MM-YYYY HH:mm:ss',
    locale: 'id',
  });
  $('.tgl').datetimepicker({
    format: 'DD-MM-YYYY',
    useCurrent: false,
    locale: 'id',
  });
  $('.tgl_indo').datetimepicker({
    format: 'DD-MM-YYYY',
    locale: 'id',
  });
  $('#tgl_1').datetimepicker({
    format: 'DD-MM-YYYY',
    locale: 'id',
  });
  $('.tgl_1').datetimepicker({
    format: 'DD-MM-YYYY',
    locale: 'id',
  });
  $('#tgl_2').datetimepicker({
    format: 'DD-MM-YYYY',
    locale: 'id',
  });
  $('#tgl_3').datetimepicker({
    format: 'DD-MM-YYYY',
    locale: 'id',
  });
  $('#tgl_4').datetimepicker({
    format: 'DD-MM-YYYY',
    locale: 'id',
  });
  $('#tgl_5').datetimepicker({
    format: 'DD-MM-YYYY',
    locale: 'id',
  });
  $('#tgl_6').datetimepicker({
    format: 'DD-MM-YYYY',
    locale: 'id',
  });
  $('#jam_1').datetimepicker({
    format: 'HH:mm:ss',
    locale: 'id',
  });
  $('#jam_2').datetimepicker({
    format: 'HH:mm:ss',
    locale: 'id',
  });
  $('#jam_3').datetimepicker({
    format: 'HH:mm:ss',
    locale: 'id',
  });

  $('#jammenit_1').datetimepicker({
    format: 'HH:mm',
    locale: 'id',
  });
  $('#jammenit_2').datetimepicker({
    format: 'HH:mm',
    locale: 'id',
  });

  $('#jammenit_3').datetimepicker({
    format: 'HH:mm',
    locale: 'id',
  });

  $('[data-rel="popover"]').popover({
    html: true,
    trigger: 'hover',
  });

  /* set otomatis hari */
  $('.datepicker.data_hari').change(function () {
    var hari = {
      0: 'Minggu',
      1: 'Senin',
      2: 'Selasa',
      3: 'Rabu',
      4: 'Kamis',
      5: 'Jumat',
      6: 'Sabtu',
    };
    var t = $(this).datepicker('getDate');
    var i = t.getDay();
    $(this).closest('.form-group').find('.hari').val(hari[i]);
  });

  $('[checked="checked"]').parent().addClass('active');
  //Format Tabel
  $('#tabel1').DataTable();
  $('#tabel2').DataTable({
    paging: false,
    lengthChange: false,
    searching: false,
    ordering: false,
    info: false,
    autoWidth: false,
    scrollX: true,
  });
  $('#tabel3').DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    scrollX: true,
  });

  // formatting datatable Program Bantuan
  $('#table-program').DataTable({
    paging: false,
    info: false,
    searching: false,
    columnDefs: [
      {
        targets: [0, 1, 3, 4, 5, 6, 7],
        orderable: false,
      },
      {
        targets: [4],
        className: 'text-center',
      },
      {
        targets: [7],
        render: function (data, type, full, meta) {
          if (data == 0) {
            return 'Tidak Aktif';
          }
          return 'Aktif';
        },
      },
    ],
  });

  //   $('#dataTableLokasi').DataTable({
  //     iDisplayLength: 50,
  //     order: [[2, 'asc']],
  //   });
  var dataTableLokasi = $('#dataTableLokasi').DataTable({
    iDisplayLength: 50,
    columnDefs: [
      {
        searchable: false,
        orderable: false,
        targets: [0, 2],
      },
      //   {
      //     targets: [1],
      //     render: function (data, type, row, meta) {
      //       return meta.row + meta.settings._iDisplayStart + 1;
      //     },
      //   },
    ],
    order: [[1, 'asc']],
  });

  dataTableLokasi
    .on('order.dt search.dt', function () {
      let i = 1;

      dataTableLokasi
        .cells(null, 1, { search: 'applied', order: 'applied' })
        .every(function (cell) {
          this.data(i++);
        });
    })
    .draw();

  //color picker with addon
  $('.my-colorpicker2').colorpicker();
  //Text Editor with addon
  $('#min-textarea').wysihtml5();

  $('ul.sidebar-menu').on('expanded.tree', function (e) {
    // Manipulasi menu perlu ada tenggang waktu -- supaya dilakukan sesudah
    // event lain selesai
    e.stopImmediatePropagation();
    setTimeout(scrollTampil($('li.treeview.menu-open')[0]), 500);
  });

  // ========== Tanda tangan laporan dan surat
  $('select[name=pamong_ttd]').change(function (e) {
    $('input[name=jabatan_ttd]').val($(this).find(':selected').data('jabatan'));
  });
  $('select[name=pamong_ketahui]').change(function (e) {
    $('input[name=jabatan_ketahui]').val(
      $(this).find(':selected').data('jabatan'),
    );
  });
  $('select[name=pamong_ttd]').trigger('change');
  $('select[name=pamong_ketahui]').trigger('change');

  // Untuk input rupiah di form surat
  // Tambahkan 'Rp.' pada saat form di ketik
  // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
  $('.rupiah').keyup(function (e) {
    var nilai = formatRupiah($(this).val(), 'Rp. ');
    $(this).val(nilai);
  });

  // Penggunaan datatable di inventaris
  var t = $('#tabel4').DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    language: {
      url: base_url + '/assets/bootstrap/js/dataTables.indonesian.lang',
    },
  });
  t.on('order.dt search.dt', function () {
    t.column(0, { search: 'applied', order: 'applied' })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
  }).draw();
});

/* Fungsi formatRupiah untuk form surat */
function formatRupiah(angka, prefix, nol_sen = true) {
  var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split = number_string.split(','),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }

  rupiah =
    split[1] != undefined ? rupiah + (nol_sen ? '' : ',' + split[1]) : rupiah;
  return prefix == undefined ? rupiah : rupiah ? 'Rp. ' + rupiah : '';
}

function scrollTampil(elem) {
  elem.scrollIntoView({ behavior: 'smooth' });
}

function checkAll(id = '#checkall') {
  $(id).click(function () {
    if ($('.table ' + id).is(':checked')) {
      $('.table input[type=checkbox]').each(function () {
        $(this).prop('checked', true);
      });
    } else {
      $('.table input[type=checkbox]').each(function () {
        $(this).prop('checked', false);
      });
    }
    $('.table input[type=checkbox]').change();
    enableHapusTerpilih();
  });
  $('[data-toggle=tooltip]').tooltip();
}

function enableHapusTerpilih() {
  if ($("input[name='id_cb[]']:checked:not(:disabled)").length <= 0) {
    $('.hapus-terpilih').addClass('disabled');
    $('.hapus-terpilih').attr('href', '#');
  } else {
    $('.hapus-terpilih').removeClass('disabled');
    $('.hapus-terpilih').attr('href', '#confirm-delete');
  }
}

function deleteAllBox(idForm, action) {
  $('#confirm-delete').modal('show');
  $('#ok-delete').click(function () {
    $('#' + idForm).attr('action', action);
    $('#' + idForm).submit();
  });
  return false;
}
function aksiBorongan(idForm, action) {
  $('#confirm-status').modal('show');
  $('#ok-status').click(function () {
    $('#' + idForm).attr('action', action);
    $('#' + idForm).submit();
  });
  return false;
}

function modalBox() {
  $('#modalBox').on('show.bs.modal', function (e) {
    var link = $(e.relatedTarget);
    var title = link.data('title');
    var modal = $(this);
    modal.find('.modal-title').text(title);
    $(this).find('.fetched-data').load(link.attr('href'));
    setTimeout(function () {
      // tambahkan csrf token
      addCsrfField(modal.find('form')[0]);
    }, 500);
  });
  return false;
}

function mapBox() {
  $('#mapBox').on('show.bs.modal', function (e) {
    var link = $(e.relatedTarget);
    $('.modal-header #myModalLabel').html(link.attr('data-title'));
    $(this).find('.fetched-data').load(link.attr('href'));
  });
}
function formAction(idForm, action, target = '') {
  csrf_semua_form();
  if (target != '') {
    $('#' + idForm).attr('target', target);
  }
  $('#' + idForm).attr('action', action);
  $('#' + idForm).submit();
}

function notification(type, message) {
  if (type == '') {
    return;
  }
  $('#maincontent').prepend(
    '' +
      '<div id="notification" class="alert alert-' +
      type +
      ' alert-dismissible">' +
      '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
      message +
      '' +
      '</div>' +
      '',
  );
}

function cari_nik() {
  $('#cari_nik').change(function () {
    $('#' + 'main').submit();
  });

  $('#cari_nik_suami').change(function () {
    $('#' + 'main').submit();
  });

  $('#cari_nik_istri').change(function () {
    $('#' + 'main').submit();
  });
}

// Ganti pilihan RW dan RT di form penduduk
function select_options(select, params) {
  var url_data = select.attr('data-source') + params;
  select.find('option').not('.placeholder').remove().end();

  $.ajax({
    url: url_data,
  }).then(function (options) {
    JSON.parse(options).forEach((option) => {
      var option_elem = $('<option>');

      option_elem
        .val(option[select.attr('data-valueKey')])
        .text(option[select.attr('data-displayKey')]);

      select.append(option_elem);
    });
  });
}

function select_options_sawah(select, params) {
  var url_data = select.attr('data-source') + params;
  select.find('option').not('.placeholder').remove().end();
  $('.loader-gif').show();

  $.ajax({
    url: url_data,
  }).then(function (options) {
    var respon = JSON.parse(options);
    console.log(respon[0].status);
    if (respon[0].status) {
      respon.forEach((option) => {
        var option_elem = $('<option>');
        var thisLuas = parseFloat(option.properties.luas);
        var luasDec = Number(thisLuas).toFixed(2);
        var namaPemilik = option.properties.pemilik;
        if (namaPemilik !== null) {
          pemilik = option.properties.pemilik;
        } else {
          pemilik = 'Pemilik tidak diketahui';
        }
        option_elem.val(option.id).text(pemilik + ' (' + luasDec + ' Ha)');
        select.append(option_elem);
      });
    } else {
      var option_elem = $('<option>');
      option_elem.val(0).text(respon[0].message);
      select.append(option_elem);
    }
    $('.loader-gif').hide();
  });
}

$(function () {
  $('#op_item input:checked')
    .parent()
    .css({ background: '#c9cdff', border: '0.5px solid #7a82eb' });
  $('#op_item input').change(function () {
    if ($(this).is('input:checked')) {
      $('#op_item input').parent().css({ background: '#fafafa' });
      $('#op_item input:checked')
        .parent()
        .css({ background: '#c9cdff', border: '0.5px solid #7a82eb' });
      $(this).parent().css({ background: '#c9cdff' });
    } else {
      $(this).parent().css({ background: '#fafafa', border: '0px' });
    }
  });
  $('#op_item label').click(function () {
    $(this).prev().trigger('click');
  });
});

function _calculateAge(birthday) {
  // birthday is a date (dd-mm-yyyy)
  if (birthday) {
    var parts = birthday.split('-');
    // Ubah menjadi format ISO yyyy-mm-dd
    // please put attention to the month (parts[0]), Javascript counts months from 0:
    // January - 0, February - 1, etc
    // https://stackoverflow.com/questions/5619202/converting-string-to-date-in-js
    var birthdate = new Date(parts[2], parts[1] - 1, parts[0]);
    var ageDifMs = new Date().getTime() - birthdate.getTime();
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
    return Math.abs(ageDate.getUTCFullYear() - 1970);
  }
}

// https://stackoverflow.com/questions/332872/encode-url-in-javascript
// Menyamakan dengan PHP urlencode supaya kurung '()' juga diencode
// Digunakan untuk mengirim nama dusun sebagai parameter url query
function urlencode(str) {
  str = (str + '').toString();

  // Tilde should be allowed unescaped in future versions of PHP (as reflected below), but if you want to reflect current
  // PHP behavior, you would need to add ".replace(/~/g, '%7E');" to the following.
  return encodeURIComponent(str)
    .replace(/!/g, '%21')
    .replace(/'/g, '%27')
    .replace(/\(/g, '%28')
    .replace(/\)/g, '%29')
    .replace(/\*/g, '%2A');
  // .replace(/%20/g, '+');
}

// https://stackoverflow.com/questions/26018756/bootstrap-button-drop-down-inside-responsive-table-not-visible-because-of-scroll
$('document').ready(function () {
  $('.table-responsive').on('show.bs.dropdown', function (e) {
    var table = $(this),
      menu = $(e.target).find('.dropdown-menu'),
      tableOffsetHeight = table.offset().top + table.height(),
      menuOffsetHeight =
        $(e.target).offset().top +
        $(e.target).outerHeight(true) +
        menu.outerHeight(true);

    if (menuOffsetHeight > tableOffsetHeight) {
      table.css('padding-bottom', menuOffsetHeight - tableOffsetHeight);
      $('.table-responsive')[0].scrollIntoView(false);
    }
  });

  $('.table-responsive').on('hide.bs.dropdown', function () {
    $(this).css('padding-bottom', 0);
  });
});

// Notifikasi
function tampil_badge(elem, url) {
  elem.load(url);
  setTimeout(function () {
    if (elem.text().trim().length) elem.show();
    else elem.hide();
  }, 500);
}

function refresh_badge(elem, url) {
  if (!elem.length) return;

  tampil_badge(elem, url);
  var refreshInbox = setInterval(function () {
    tampil_badge(elem, url);
  }, 10000);
}
