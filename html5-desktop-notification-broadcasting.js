(function(){

var p         = PUBNUB
,   config    = p.$('desktop-notifications-config')
,   channel   = p.attr( config, 'channel-name' )
,   segregate = p.attr( config, 'segregate-notifications-by-page' ) == 'true'
,   html5     = window.webkitNotifications
,   count     = 1
,   safe_rx   = /[<>\r\n]+/g
,   safe      = function(t) { return t.replace( safe_rx, '' ) };

//
// HTML5 Desktop Notification
//
// Use this code to mass broadcast to everyone on this page.
//
// Example:
//
//     PUBNUB.notify(
//         image : "image.jpg",
//         title : "Title Test",
//         body  : "Hello World!"
//     );
//
PUBNUB.notify = function(args) {
    if (!PUBNUB.notify.enable(function(){
        PUBNUB.notify(args);
    })) return;

    PUBNUB.publish({
        channel : PUBNUB.notify.channel,
        message : {
            image : args.image,
            title : safe(args.title),
            body  : safe(args.body)
        }
    });
};

//
// HTML5 ENABLE Desktop Notifications
//
// Use this code to enable receiving Notifications.
// After Notifications are enabled,
// use the PUBNUB.notify() function to Send Messages.
//
// Example:
//
//    PUBNUB.bind(
//        'mousedown,touchstart',
//        PUBNUB.$('broadcast-enable'),
//        PUBNUB.notify.enable
//    );
PUBNUB.notify.enable = function(callback) {
    if (html5 && html5.checkPermission()) {
        html5.requestPermission(callback);
        return false;
    }

    return true;
};

//
// Utility to test Notifications
//
PUBNUB.notify.ready = function() {
    return !html5 || !html5.checkPermission();
};

//
// Popular Hash Function
//
function hash(buf) {
    var hash = 5381
    ,   len  = buf.length
    ,   chr  = 0;

    while (len--) hash = ((hash << 5) + hash) + buf.charCodeAt(chr++);

    return hash;
}

//
// Listen For Notifications
//
p.notify.channel = segregate ? hash(location.href) : channel;
p.subscribe({
    channel  : PUBNUB.notify.channel,
    callback : function(message) {
        return ( html5 ? html5_notify : legacy_notify )(
            message.image,
            safe(message.title + ' ' + (count++)),
            safe(message.body)
        );
    }
});

//
// HTML5 Desktop Notification Function
//
function html5_notify( image, title, body ) {
    //
    // Do we need to request permission?
    //
    if (html5.checkPermission()) {
        return html5.requestPermission(function(){
            html5_notify( image, title, body );
        });
    }

    //
    // Show HTML5 Desktop Notice
    // This appears OUTSIDE the web browser.
    //
    var notice = html5.createNotification(
        image, title, body
    );
    notice.show();

    return notice;
}

//
// Legacy Notification Function
//
function legacy_notify( image, title, body ) {
    var div   = p.create('div')
    ,   style = [
        '-webkit-border-radius:10px',
        '-moz-border-radius:10px',
        '-o-border-radius:10px',
        'border-radius:10px',
        '-webkit-box-shadow:0 0 20px #000',
        '-moz-box-shadow:0 0 20px #000',
        '-o-box-shadow:0 0 20px #000',
        'box-shadow:0 0 20px #000'
    ].join(';')
    ,   notice = {
        hide : function() {
            p.search('body')[0].removeChild(div);
            return true;
        }
    };

    p.attr( div, 'style', style );
    p.css( div, {
        position   : 'fixed',
        cursor     : 'pointer',
        bottom     : '20px',
        right      : '20px',
        background : '#fff',
        padding    : '10px',
        width      : '300px',
        border     : '1px solid #ddd'
    } );

    div.innerHTML = p.supplant( [
        "<img src='{image}' style=float:left;padding-right:10px />",
        "<div style='font-family:b'>{title}</div>",
        "<div>{body}</div>"
    ].join(''), {
        style : style,
        image : image,
        title : safe(title),
        body  : safe(body)
    } );

    p.bind( 'click', div, notice.hide );

    //
    // Show Legacy Notice
    // This appears inside the web browser.
    //
    p.search('body')[0].appendChild(div);

    return notice;
}

})();
