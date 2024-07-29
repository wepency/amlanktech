@extends('Frontend.Layouts.Front-pages')

@section('title', 'موقع اتحاد الملاك')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
{{--                <div class="block-box post-input-tab">--}}
{{--                    <ul class="nav nav-tabs" role="tablist">--}}
{{--                        <li class="nav-item" role="presentation" data-toggle="tooltip" data-placement="top" title=""--}}
{{--                            data-original-title="STATUS">--}}
{{--                            <a class="nav-link active" data-toggle="tab" href="#post-status" role="tab"--}}
{{--                               aria-selected="true"><i class="icofont-copy"></i>Status</a>--}}
{{--                        </li>--}}
{{--                        --}}
{{--                        <li class="nav-item" role="presentation" data-toggle="tooltip" data-placement="top" title=""--}}
{{--                            data-original-title="MEDIA">--}}
{{--                            <a class="nav-link" data-toggle="tab" href="#post-media" role="tab" aria-selected="false"><i--}}
{{--                                    class="icofont-image"></i>Photo/ Video Album</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item" role="presentation" data-toggle="tooltip" data-placement="top" title=""--}}
{{--                            data-original-title="BLOG">--}}
{{--                            <a class="nav-link" data-toggle="tab" href="#post-blog" role="tab" aria-selected="false"><i--}}
{{--                                    class="icofont-list"></i>Blog</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                    <div class="tab-content">--}}
{{--                        <div class="tab-pane fade show active" id="post-status" role="tabpanel">--}}
{{--                            <textarea name="status-input" id="status-input1" class="form-control textarea"--}}
{{--                                      placeholder="Share what are you thinking . . ." cols="30" rows="6"></textarea>--}}
{{--                        </div>--}}
{{--                        <div class="tab-pane fade" id="post-media" role="tabpanel">--}}
{{--                            <!-- <label>Media Gallery</label>--}}
{{--    <a href="#" class="media-insert"><i class="icofont-upload-alt"></i>Upload</a> -->--}}
{{--                            <textarea name="status-input" id="status-input2" class="form-control textarea"--}}
{{--                                      placeholder="Share what are you thinking . . ." cols="30" rows="6"></textarea>--}}
{{--                        </div>--}}
{{--                        <div class="tab-pane fade" id="post-blog" role="tabpanel">--}}
{{--                            <textarea name="status-input" id="status-input3" class="form-control textarea"--}}
{{--                                      placeholder="Share what are you thinking . . ." cols="30" rows="6"></textarea>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="post-footer">--}}
{{--                        <div class="insert-btn">--}}
{{--                            <a href="#"><i class="icofont-photobucket"></i></a>--}}
{{--                            <a href="#"><i class="icofont-tags"></i></a>--}}
{{--                            <a href="#"><i class="icofont-location-pin"></i></a>--}}
{{--                        </div>--}}
{{--                        <div class="submit-btn">--}}
{{--                            <a href="#">Post Submit</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}


                <h3>المنشورات</h3>
                <hr />

                <div class="block-box post-view mt-4">

                    <div class="post-header">
                        <div class="media">
                            <div class="user-img">
                                <img src="media/figure/chat_5.jpg" alt="Aahat">
                            </div>
                            <div class="media-body">
                                <div class="user-title"><a href="user-timeline.html">Rebeca Powel</a></div>
                                <ul class="entry-meta">
                                    <li class="meta-privacy"><i class="icofont-world"></i>Public</li>
                                    <li class="meta-time">2 mins ago</li>
                                </ul>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                ...
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Close</a>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </div>
                    <div class="post-body">
                        <p>Dhaka is wonderful no matter what! <i class="icofont-wink-smile"></i></p>
                        <div class="post-img">
                            <img src="media/figure/post_10.jpg" alt="Post">
                        </div>
                        <div class="post-meta-wrap">
                            <div class="post-meta">
                                <div class="post-reaction">
                                    <div class="reaction-icon">
                                        <img src="media/figure/reaction_1.png" alt="icon">
                                        <img src="media/figure/reaction_2.png" alt="icon">
                                        <img src="media/figure/reaction_3.png" alt="icon">
                                    </div>
                                    <div class="meta-text">15</div>
                                </div>
                            </div>
                            <div class="post-meta">
                                <div class="meta-text">2 Comments</div>
                                <div class="meta-text">05 Share</div>
                            </div>
                        </div>
                    </div>
                    <div class="post-footer">
                        <ul>
                            <li class="post-react">
                                <a href="#"><i class="icofont-thumbs-up"></i>React!</a>
                                <ul class="react-list">
                                    <li><a href="#"><img src="media/figure/reaction_1.png" alt="Like"></a></li>
                                    <li><a href="#"><img src="media/figure/reaction_3.png" alt="Like"></a></li>
                                    <li><a href="#"><img src="media/figure/reaction_4.png" alt="Like"></a></li>
                                    <li><a href="#"><img src="media/figure/reaction_2.png" alt="Like"></a></li>
                                    <li><a href="#"><img src="media/figure/reaction_7.png" alt="Like"></a></li>
                                    <li><a href="#"><img src="media/figure/reaction_6.png" alt="Like"></a></li>
                                    <li><a href="#"><img src="media/figure/reaction_5.png" alt="Like"></a></li>
                                </ul>
                            </li>
                            <li><a href="#"><i class="icofont-comment"></i>Comment</a></li>
                            <li class="post-share">
                                <a href="javascript:void(0);" class="share-btn"><i class="icofont-share"></i>Share</a>
                                <ul class="share-list">
                                    <li><a href="#" class="color-fb"><i class="icofont-facebook"></i></a></li>
                                    <li><a href="#" class="color-messenger"><i
                                                class="icofont-facebook-messenger"></i></a></li>
                                    <li><a href="#" class="color-instagram"><i class="icofont-instagram"></i></a></li>
                                    <li><a href="#" class="color-whatsapp"><i class="icofont-brand-whatsapp"></i></a>
                                    </li>
                                    <li><a href="#" class="color-twitter"><i class="icofont-twitter"></i></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="block-box load-more-btn">
                    <a href="#" class="item-btn"><i class="icofont-refresh"></i>تحميل المزيد من المنشورات</a>
                </div>
            </div>
        </div>
    </div>

@endsection
