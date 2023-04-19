{{-- modal start  --}}
            <!-- Large modal -->
            
            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

                
                  
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        
                    <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3> All Category
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </h3>
                        </div>
                        <div class="card-body">
                                <div class="container">

                                    <table class="table table-bordered table-hover" id="example2">
                                        <thead>
                                        <tr>
                                          <th style="text-align: center">Title</th>
                                          <th style="text-align: center">Link</th>
                                          <th style="text-align: center">Image</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                              @foreach (\App\Models\Photo::orderby('id','DESC')->get() as  $data)
                                            <tr>
                                              <td style="text-align: center">{{$data->title}}</td>
                                              <td>
                                                @if ($data->image)
                                                <input type="text" class="form-control" id="copy_{{$data->id}}" value="{{asset($data->link)}}">
                                              <button value="copy" class="btn-sm btn-success" onclick="copyToClipboard('copy_{{$data->id}}')">Copy!</button>

                                              
                                                @endif
                                            </td>
                                              <td style="text-align: center">
                                                  @if ($data->image)
                                                  <img src="{{asset('images/thumbnail/'.$data->image)}}" height="60px" width="110px" alt="">
                                                  @endif
                                              </td>
                                              
                                              
                                            </tr>
                                            @endforeach
                                          </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
                    </div>
                </div>
            </div>
        {{-- modal end  --}}