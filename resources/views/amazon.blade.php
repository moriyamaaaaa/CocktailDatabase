<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
</head>
<body>
<script charset="utf-8" type="text/javascript">
    amzn_assoc_ad_type = "{{$option['amzn_assoc_ad_type']??'responsive_search_widget'}}";
    amzn_assoc_tracking_id = "trc05-22";
    amzn_assoc_marketplace = "amazon";
    amzn_assoc_region = "{{$option['amzn_assoc_region']??'JP'}}";
    amzn_assoc_placement = "{{$option['amzn_assoc_placement']??''}}";
    amzn_assoc_search_type = "{{$option['amzn_assoc_search_type']??'search_widget'}}";
    amzn_assoc_width = "{{$option['amzn_assoc_width']??300}}";
    amzn_assoc_height = "{{$option['amzn_assoc_height']??250}}";
    amzn_assoc_default_search_category = "{{$option['amzn_assoc_default_search_category']??'Grocery'}}";
    amzn_assoc_default_search_key = "{{$option['amzn_assoc_default_search_key']}}";//必須！
    amzn_assoc_theme = "{{$option['amzn_assoc_theme']??'dark'}}";
    amzn_assoc_bg_color = "{{$option['amzn_assoc_bg_color']??'384D58'}}";
</script>
<script src="//z-fe.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&Operation=GetScript&ID=OneJS&WS=1&MarketPlace={{$option["amzn_assoc_region"]??"JP"}}"></script>
</body>
</html>
