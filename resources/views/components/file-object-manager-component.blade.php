<div class="tab-container">
    <div class="tab-menu">
        <ul>
            <li><a href="#" class="tab-a active-a" data-id="upload">Upload</a></li>
            <li><a href="#" class="tab-a" data-id="list">Choose from library</a></li>
        </ul>
    </div><!--end of tab-menu-->
    <div class="tab tab-active" data-id="upload">
        <x-fom-file-object-upload-component>

        </x-fom-file-object-upload-component>
    </div><!--end of tab one-->

    <div class="tab " data-id="list">
        <div id="file-object-list">

        </div>
    </div><!--end of tab two-->
</div><!--end of container-->

<style>
    .tab-container{
        border-radius: 4px;
    }
    .tab-menu{}
    .tab-menu ul{
        padding: 0;
    }
    .tab-menu ul li{
        list-style-type: none;
        display: inline-block;
    }
    .tab-menu ul li a{
        text-decoration: none;
        color: rgba(0,0,0,0.4);
        background-color: lightgrey;
        padding: 7px 25px;
        border-radius: 4px;
    }
    .tab-menu ul li a.active-a{
        background-color: grey;
        color: #ffffff;
    }
    .tab{
        display: none;
    }
    .tab h2{
        color: rgba(0,0,0,.7);
    }
    .tab p{
        color: rgba(0,0,0,0.6);
        text-align: justify;
    }
    .tab-active{
        display: block;
    }
</style>

<script>
    $(document).ready(function(){
        $('.tab-a').click(function(){
            $(".tab").removeClass('tab-active');
            $(".tab[data-id='"+$(this).attr('data-id')+"']").addClass("tab-active");
            $(".tab-a").removeClass('active-a');
            $(this).parent().find(".tab-a").addClass('active-a');
        });
    });
</script>
