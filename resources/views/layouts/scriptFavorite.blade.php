<script>
        $(".icon-love").click(function(){
            $.ajax({
                type: 'post',
                url: '{{route("add.favorite")}}',
                data: {
                    '_token' : '{{csrf_token()}}',
                    'id' : this.getAttribute('data'),
                },
                success: function(data) {
                  console.log(data)
                },
                error: function(reject) {

                },
            });
        });

    </script>