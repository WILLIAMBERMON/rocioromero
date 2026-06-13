$(document).ready(function() {
    $("#dependencia").select2();
});

$("#file-3").fileinput({
    theme: 'fa5',
    browseClass: "btn btn-primary",
    overwriteInitial: false,
    initialPreviewAsData: true,
    //uploadUrl: 'http://localhost/plugins/test-upload',
    initialPreview: [
        "https://dummyimage.com/640x360/a0f.png&text=Transport+1",
        "https://dummyimage.com/640x360/3a8.png&text=Transport+2",
        "https://dummyimage.com/640x360/6ff.png&text=Transport+3"
    ],
    initialPreviewConfig: [
        {caption: "transport-1.jpg", size: 329892, width: "120px", url: "{$url}", key: 1, zoomData: 'https://dummyimage.com/1920x1080/a0f.png&text=Transport+1', description: '<h5>NUMBER 1</h5> The first choice for transport. This is the future.'},
        {caption: "transport-2.jpg", size: 872378, width: "120px", url: "{$url}", key: 2, zoomData: 'https://dummyimage.com/1920x1080/3a8.png&text=Transport+2', description: '<h5>NUMBER 2</h5> The second choice for transport. This is the future.'},
        {caption: "transport-3.jpg", size: 632762, width: "120px", url: "{$url}", key: 3, zoomData: 'https://dummyimage.com/1920x1080/6ff.png&text=Transport+3', description: '<h5>NUMBER 3</h5> The third choice for transport. This is the future.'}
    ]
}).on('filebatchpreupload', function(e, data) {
    return {
        message: 'Error here',
        data: data
    }
});