// import jszip from 'jszip';
// import pdfmake from 'pdfmake';
// import * as bootstrap from 'bootstrap';
// import DataTable from 'datatables.net-bs5';
// import $ from 'jquery';
// import 'datatables.net-autofill-dt';
// import 'datatables.net-buttons-dt';
// import 'datatables.net-buttons/js/buttons.colVis.mjs';
// import 'datatables.net-buttons/js/buttons.html5.mjs';
// import 'datatables.net-buttons/js/buttons.print.mjs';
// import 'datatables.net-colreorder-dt';
// import DateTime from 'datatables.net-datetime';
// import 'datatables.net-fixedcolumns-dt';
// import 'datatables.net-fixedheader-dt';
// import 'datatables.net-keytable-dt';
// import 'datatables.net-responsive-dt';
// import 'datatables.net-rowgroup-dt';
// import 'datatables.net-rowreorder-dt';
// import 'datatables.net-scroller-dt';
// import 'datatables.net-searchbuilder-dt';
// import 'datatables.net-searchpanes-dt';
// import 'datatables.net-select-dt';
// import 'datatables.net-staterestore-dt';
 
// DataTable.Buttons.jszip(jszip);
// DataTable.Buttons.pdfMake(pdfmake);



// $(document).ready(function () {
//     $('#exampleTable').DataTable({
//         dom: '<"flex mb-4 "<" "f> <""l>   <"flex-grow"B>> t <"row py-4"<"col-md-6"i><"col-md-6 text-end"p>>',
//         buttons: [


//             {
//                 extend: 'excel',
//                 text: 'Excel'
//             },
//             {
//                 extend: 'pdf',
//                 text: 'PDF'
//             },
//             {
//                 extend: 'print',
//                 text: 'Print'
//             }
//         ],
//         language: {
//             search: "Cari: ",
//             lengthMenu: "Show _MENU_ Data",
//             info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
//             paginate: {
//                 first: "Awal",
//                 last: "Akhir",
//                 next: "Next",
//                 previous: "Previous"
//             }
//         },

//         lengthMenu: [10, 25, 50, 100],
//         pageLength: 10,
//         order: [
//             [0, 'desc']
//         ],
//     });
// });


// window.formatRupiah= function(angka) {
//     value = angka.value.replace(/\D/g, "");

//     if (value === "") {
//         angka.value = "";
//         return "";
//     }
//     console.log(value);

//     let reverse = value.split('').reverse().join('');
//     let formatted = reverse.match(/\d{1,3}/g).join('.').split('').reverse().join('');
//     // formatted = formatted;
//     angka.value = formatted;
// }