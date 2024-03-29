<div class='form-group {{$header_group_class}} {{ ($errors->first($name))?"has-error":"" }}' id='form-group-{{$name}}' style="{{@$form['style']}}">
    <label class='col-sm-2 control-label'>{{$form['label']}}
        @if($required)
            <span class='text-danger' title='{!! trans('crudbooster.this_field_is_required') !!}'>*</span>
        @endif
    </label>

    <div class="{{$col_width?:'col-sm-10'}}">
        @if($value)
            <?php
            if(Storage::exists($value) || file_exists($value)):
            $url = asset($value);
            $ext = pathinfo($url, PATHINFO_EXTENSION);
            $images_type = array('jpg', 'png', 'gif', 'jpeg', 'bmp', 'tiff');
            if(in_array(strtolower($ext), $images_type)):
            ?>
            <p><a data-lightbox='roadtrip' href='{{$url}}'><img style='max-width:160px' title="Image For {{$form['label']}}" src='{{$url}}'/></a></p>
            <?php else:?>
            <p><a href='{{$url}}'>{{trans("crudbooster.button_download_file")}}</a></p>
            <?php endif;
            echo "<input type='hidden' name='_$name' value='$value'/>";
            else:
                echo "<p class='text-danger'><i class='fas fa-exclamation-triangle'></i> ".trans("crudbooster.file_broken")."</p>";
            endif;


            /*
            !Fix Delete Image Error
            ? change $row->id to $row->pk;
            */
            $module = CRUDBooster::getCurrentModule();
            $table_name = $module->table_name;
            $primaryKey = CRUDBooster::pk($table_name);
            $row->pk = $row->$primaryKey;
            ?>

            @if(!$readonly || !$disabled)
                <p><a class='btn btn-danger btn-delete btn-sm' onclick="if(!confirm('{{trans("crudbooster.delete_title_confirm")}}')) return false"
                      href='{{url(CRUDBooster::mainpath("delete-image?image=".$value."&id=".$row->pk."&column=".$name))}}'><i
                                class='fas fa-ban'></i> {{trans('crudbooster.text_delete')}} </a></p>
            @endif
        @endif
        @if(!$value)


                <p><a data-lightbox='roadtrip' href='#'><img id='image-preview-{{$name}}' style='max-width:160px;display: none;' title="Image" src='#'/></a></p>

            <input type='file' id="{{$name}}" title="{{$form['label']}}" {{$required}} {{$readonly}} {{$disabled}} class='form-control' name="{{$name}}"/>
            <p class='help-block'>{{ @$form['help'] }}</p>

            <script>
            window.onload = function(){
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            if(e.target.result.indexOf("data:image")==-1)
                            {   
                                $('#image-preview-{{$name}}').hide();
                            }   
                            else {
                                $('#image-preview-{{$name}}').attr('src', e.target.result).show();
                            }
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $("#{{$name}}").change(function(){
                    readURL(this);
                });
            }
            </script>
        @else
            <p class='text-muted'><em>{{trans("crudbooster.notice_delete_file_upload")}}</em></p>
        @endif
        <div class="text-danger">{!! $errors->first($name)?"<i class='fas fa-info-circle'></i> ".$errors->first($name):"" !!}</div>

    </div>

</div>
