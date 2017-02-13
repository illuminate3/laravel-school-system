@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-lg-2">
            <div class="box1">
                <div class="list-group">
                    <a class="btn btn-danger mar-10 list-group-item text-white" id="link3" data-target="#compose">Compose</a>
                    <a class="list-group-item" id="link1" data-target="#inbox">Inbox</a>
                    <a class="list-group-item" id="link2" data-target="#sent">Sent</a>
                    <a class="list-group-item" id="link4" data-target="#reply_sec">Single mail</a>
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            <div id="inbox_emails" class="box1">
                <div class="mail">
                    <img src="../resources/assets/img/avatar.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="mail">
                    <img src="../resources/assets/img/avatar5.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="mail">
                    <img src="../resources/assets/img/avatar7.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="mail">
                    <img src="../resources/assets/img/avatar1.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="mail">
                    <img src="../resources/assets/img/avatar6.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="mail">
                    <img src="../resources/assets/img/avatar.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="mail">
                    <img src="../resources/assets/img/avatar5.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="mail">
                    <img src="../resources/assets/img/avatar7.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
            </div>
            <div id="compose" class="box1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group" role="group" aria-label="...">
                            <button type="button" class="btn btn-default" title="save"><i
                                        class="material-icons text-default md-18">description</i></button>
                            <button type="button" class="btn btn-default" title="delete"><i
                                        class="material-icons text-default md-18">delete</i></button>
                        </div>
                    </div>
                </div>
                <div class="row margin-top">
                    <div class="col-md-12">
                        <form class="form-horizontal" method="post" action="#">
                            <div class="form-group">
                                <label for="to_addr" class="col-sm-2 control-label">To:</label>
                                <div class="col-sm-10">
                                    <select class="select2" class="form-control" id="to_addr" name="to_addr" multiple>
                                        <option>Adam <span> &lt;adam@lcrm.com&gt;</span></option>
                                        <option>John <span> &lt;john@lcrm.com&gt;</span></option>
                                        <option>Gran <span> &lt;gran@lcrm.com&gt;</span></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="compose_sub" class="col-sm-2 control-label">Subject:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="compose_sub" name="compose_sub">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="compose_cont" class="col-sm-2 control-label">Content:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="compose_cont" name="compose_cont"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" class="btn btn-primary" value="Send">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="sent" class="box1">
                <div class="mail">
                    <img src="../resources/assets/img/avatar.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="mail">
                    <img src="../resources/assets/img/avatar5.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="mail">
                    <img src="../resources/assets/img/avatar7.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="mail">
                    <img src="../resources/assets/img/avatar1.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="mail">
                    <img src="../resources/assets/img/avatar6.jpg" class="img-responsive img-circle pull-left"
                         width="45px" height="45px">
                    <a href class="mail-content">Lorem Ipsum is simply dummy</a><span
                            class="pull-right">Yesterday</span> <br>
                    <div class="mail-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
            </div>
            <div id="reply_sec">
                <div class="row margin-top">
                    <div class="col-lg-12">
                        <div class="box1">
                            <ul class="list-inline mar-20">
                                <li class="btn btn-default"><i class="material-icons" title="Back to inbox">keyboard_backspace</i>
                                </li>
                                <li class="btn btn-default"><i class="material-icons" title="Delete">delete</i></li>
                                <li class="btn btn-default"><i class="material-icons" title="Move to">loyalty</i></li>
                            </ul>
                            <h4>Lorem Ipsum is simply dummy</h4>
                            <hr>
                            <img src="../resources/assets/img/avatar.jpg" class="img-responsive user_img">
                            <p class="margin-top">from john@lcrm.com
                                <small>on</small>
                                12:20 12/01/2016
                            </p>
                            <br><br>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p><br>

                            <strong id="reply">Click Here to <span>Reply</span></strong>

                            <div id="reply_mail">
                                <form action="#" method="post">
                                    <div class="form-group">
                                        <label class="sr-only" for="reply_name"></label>
                                        <input type="mail" class="form-control" id="reply_name" name="reply_name"
                                               value="john@lcrm.com">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="reply_cont"></label>
                                        <textarea class="form-control" id="reply_cont" name="reply_cont"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="submit" class=" pull-left btn btn-primary" value="Send">
                                            <a class="btn btn-default pull-right"><i class="material-icons"
                                                                                     title="Delete">delete</i></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            $("#compose_cont,#reply_cont").summernote({
                height: '300'
            });
            $("#inbox_emails").show();
            $("#link1").addClass("active");
            $("#compose").hide();
            $("#sent").hide();
            $("#reply_sec").hide();
            $("#link3").click(function () {
                $("#compose").show();
                $("#inbox_emails").hide();
                $("#sent").hide();
                $("#reply_sec").hide();
                $(".list-group-item").removeClass("active");
            });
            $("#link1").click(function () {
                $("#inbox_emails").show();
                $("#compose").hide();
                $("#sent").hide();
                $("#reply_sec").hide();
                $(".list-group-item").removeClass("active");
                $(this).addClass("active");
            });
            $("#link2").click(function () {
                $("#sent").show();
                $("#inbox_emails").hide();
                $("#compose").hide();
                $("#reply_sec").hide();
                $(".list-group-item").removeClass("active");
                $(this).addClass("active");
            });
            $("#link4").click(function () {
                $("#sent").hide();
                $("#inbox_emails").hide();
                $("#compose").hide();
                $("#reply_sec").show();
                $(".list-group-item").removeClass("active");
                $(this).addClass("active");
            });

            $("#reply_mail").hide();
            $("#reply").click(function () {
                $("#reply_mail").show();
                $(this).hide();
            })


        })
    </script>
@stop