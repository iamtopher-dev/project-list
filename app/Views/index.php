<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.6.3/fabric.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/1.8.349/pdf.min.js"></script>
</head>

<body>
    <span style="font-size: 14px"><b>Load PDF</b></span>
    <input id="pdf-upload" type="file">

    <canvas id="pdfcanvas"></canvas>
    <script>
        document.querySelector("#pdf-upload").addEventListener("change", function(e) {
            var file = e.target.files[0]
            if (file.type != "application/pdf") {
                console.error(file.name, "is not a pdf file.")
                return
            }

            var fileReader = new FileReader();

            fileReader.onload = function() {
                var typedarray = new Uint8Array(this.result);

                PDFJS.getDocument(typedarray).then(function(pdf) {
                    // you can now use *pdf* here
                    console.log("the pdf has ", pdf.numPages, "page(s).")
                    pdf.getPage(pdf.numPages).then(function(page) {
                        // you can now use *page* here
                        var viewport = page.getViewport(2.0);
                        var canvasEl = document.querySelector("canvas")
                        canvasEl.height = viewport.height;
                        canvasEl.width = viewport.width;

                        page.render({
                            canvasContext: canvasEl.getContext('2d'),
                            viewport: viewport
                        }).then(function() {

                            var bg = canvasEl.toDataURL("image/png");

                            fabric.Image.fromURL(bg, function(img) {
                                img.scaleToHeight(1123);
                                canvas.setHeight(1123);
                                canvas.setWidth(1588);
                                canvas.setBackgroundImage(img);
                            });
                            canvas.renderAll();
                        });
                    });

                });
            };
            fileReader.readAsArrayBuffer(file);
        });
    </script>
</body>

</html>