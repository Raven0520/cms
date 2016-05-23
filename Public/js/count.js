/**
 * Created by Raven on 2016/5/20.
 */
/*
 计数器JS文件
 */
var newsIds = {};
$(".news_count").each(function (i) {
    newsIds[i] = $(this).attr("news-id");
});
//调试
// console.log(newsIds);

url = "/index.php?c=index&a=getCount";

$.post(url, newsIds, function (result) {
    if (result.status == 1) {
        //调试
        // console.log(result.data);
        counts = result.data;
        $.each(counts, function (news_id, count) {
            $(".node-" + news_id).html(count);
        })
    }
}, "JSON");