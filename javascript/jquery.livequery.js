(function(a){a.extend(a.fn,{livequery:function(b,c,d){var e=this,f;if(a.isFunction(b)){d=c;c=b;b=undefined}a.each(a.livequery.queries,function(g,h){if(e.selector==h.selector&&e.context==h.context&&b==h.type&&(!c||c.$lqguid==h.fn.$lqguid)&&(!d||d.$lqguid==h.fn2.$lqguid))return(f=h)&&false});f=f||new a.livequery(this.selector,this.context,b,c,d);f.stopped=false;f.run();return this},expire:function(b,c,d){var e=this;if(a.isFunction(b)){d=c;c=b;b=undefined}a.each(a.livequery.queries,function(f,g){if(e.selector==
g.selector&&e.context==g.context&&(!b||b==g.type)&&(!c||c.$lqguid==g.fn.$lqguid)&&(!d||d.$lqguid==g.fn2.$lqguid)&&!this.stopped)a.livequery.stop(g.id)});return this}});a.livequery=function(b,c,d,e,f){this.selector=b;this.context=c;this.type=d;this.fn=e;this.fn2=f;this.elements=[];this.stopped=false;this.id=a.livequery.queries.push(this)-1;e.$lqguid=e.$lqguid||a.livequery.guid++;if(f)f.$lqguid=f.$lqguid||a.livequery.guid++;return this};a.livequery.prototype={stop:function(){var b=this;if(this.type)this.elements.unbind(this.type,
this.fn);else this.fn2&&this.elements.each(function(c,d){b.fn2.apply(d)});this.elements=[];this.stopped=true},run:function(){if(!this.stopped){var b=this,c=this.elements,d=a(this.selector,this.context),e=d.not(c);this.elements=d;if(this.type){e.bind(this.type,this.fn);c.length>0&&a.each(c,function(f,g){a.inArray(g,d)<0&&a.event.remove(g,b.type,b.fn)})}else{e.each(function(){b.fn.apply(this)});this.fn2&&c.length>0&&a.each(c,function(f,g){a.inArray(g,d)<0&&b.fn2.apply(g)})}}}};a.extend(a.livequery,
{guid:0,queries:[],queue:[],running:false,timeout:null,checkQueue:function(){if(a.livequery.running&&a.livequery.queue.length)for(var b=a.livequery.queue.length;b--;)a.livequery.queries[a.livequery.queue.shift()].run()},pause:function(){a.livequery.running=false},play:function(){a.livequery.running=true;a.livequery.run()},registerPlugin:function(){a.each(arguments,function(b,c){if(a.fn[c]){var d=a.fn[c];a.fn[c]=function(){var e=d.apply(this,arguments);a.livequery.run();return e}}})},run:function(b){if(b!=
undefined)a.inArray(b,a.livequery.queue)<0&&a.livequery.queue.push(b);else a.each(a.livequery.queries,function(c){a.inArray(c,a.livequery.queue)<0&&a.livequery.queue.push(c)});a.livequery.timeout&&clearTimeout(a.livequery.timeout);a.livequery.timeout=setTimeout(a.livequery.checkQueue,20)},stop:function(b){b!=undefined?a.livequery.queries[b].stop():a.each(a.livequery.queries,function(c){a.livequery.queries[c].stop()})}});a.livequery.registerPlugin("append","prepend","after","before","wrap","attr",
"removeAttr","addClass","removeClass","toggleClass","empty","remove","html","load");a(function(){a.livequery.play()})})(jQuery);