<script>
    $(document).ready(function () {
        $('#folder').treed({openedClass:'fa-folder-open', closedClass:'fa-folder'});
        $(".items").click(function () {
            $("#loader-wrapper").css("visibility","visible");
            var id = $(this).data('id');
            loadUrl(id);
            setTimeout(function () {
                $("#loader-wrapper").css("visibility","hidden");
            },500);
        });

        @if(session('id'))
            var itemID = "{{ session('id') }}";
            loadUrl(itemID);
        @endif

        function loadUrl(id)
        {
            var url = "{{ url('/load/') }}/"+id;
            $(".load_content").load(url,function(){
                $("#submitForm").submit(function(e){
                    $("#loader-wrapper").css("visibility","visible");
                });

                $("#addNodeForm").submit(function(e){
                    e.preventDefault();
                    $("#loader-wrapper").css("visibility","visible");
                    var formData = new FormData(this);
                    console.log(formData);
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            console.log(res);
                            if(res==0){
                                alert("Unable to create folder. Current folder is not empty!");
                            }else{
                                window.location.reload();
                            }
                            $("#loader-wrapper").css("visibility","hidden");
                        }
                    })
                });

                $(".deleteItem").click(function(){
                    var c = confirm("Are you sure you want to delete this document?");
                    var id = $(this).data("id");
                    var node = $(this).data("node");
                    var url = "{{ url('/delete/') }}/"+id;
                    if(c){
                        $("#loader-wrapper").css("visibility","visible");
                        $.ajax({
                            url: url,
                            type: "GET",
                            success: function () {
                                loadUrl(node);
                                setTimeout(function () {
                                    $("#loader-wrapper").css("visibility","hidden");
                                },500);
                            }
                        });
                    }
                });

                $("#deleteNode").on('click',function(){
                    var id = $(this).data('id');
                    var url = "{{ route('delete.node') }}";
                    var c = confirm("Are you sure you want to delete this folder?");
                    if(c){
                        $("#loader-wrapper").css("visibility","visible");
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: { id: id },
                            success: function (res) {
                                setTimeout(function () {
                                    window.location.replace("{{ route('home') }}");
                                    $("#loader-wrapper").css("visibility","hidden");
                                },500);
                            }
                        });
                    }

                });
            });


        }
    });
</script>
