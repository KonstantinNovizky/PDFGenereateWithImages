$(document).ready(function () {
    $("[name='view_style']").change(function () {
        var view = $(this).attr('target_class');
        $('.' + view).toggle();
    });
});

function generatePDF(selfbtn, id) {
    var element = $('#' + id);
    $('.pdf-generating').show();
    $(selfbtn).hide();
    element.css({ 'position': 'absolute', 'left': '0px', 'top': '0px' });

    $('body').scrollTop(0);
    var HTML_Width = element.width();
    var HTML_Height = element.height();
    var top_left_margin = 15;
    var PDF_Width = HTML_Width * 1.05;
    var PDF_Height = (PDF_Width * 1.5);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

    html2canvas(element.get(0), { allowTaint: true, useCORS: true }).then(function (canvas) {

        var imgData = canvas.toDataURL("image/png");

        var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);

        pdf.addImage(imgData, 'JPEG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);

        for (var i = 1; i <= totalPDFPages; i++) {
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'JPEG', top_left_margin, -(PDF_Height * i), canvas_image_width, canvas_image_height);
        }

        pdf.save("HTML-Document.pdf");

        element.css({ 'position': 'unset', 'left': 'unset', 'top': 'unset' });
        $('.pdf-generating').hide();
        $(selfbtn).show();
    });
}
