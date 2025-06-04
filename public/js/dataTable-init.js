$(document).ready(function () {
    $('.dataTableClass').DataTable({
        dom: '<"flex mb-4 "<" "f> <""l>   <"flex-grow"B>> t <"row py-4"<"col-md-6"i><"col-md-6 text-end"p>>',
        stripeClasses: [],
        destroy: true,
        language: {
            search: "Cari: ",
            lengthMenu: "Show _MENU_ Data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "Next",
                previous: "Previous"
            }
        },
        lengthMenu: [10, 25, 50, 100],
        pageLength: 10,
        order: [
            [0, 'desc']
        ],
        
    });

    $('.dataTableClass_no_pagination').DataTable({
        dom: '<"flex mb-4 "<" "f> <""l>   <"flex-grow"B>> t <"row py-4"<"col-md-6"i><"col-md-6 text-end"p>>',
        stripeClasses: [],
        destroy: true,
        language: {
            search: "Cari: ",

        },
   
        order: [
            [0, 'desc']
        ],
        lengthMenu: [10, 25, 50, 100],
        pageLength: 10,
        ordering: false,
        
    });

    
});
