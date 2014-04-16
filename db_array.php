<?php

$tcmls = array("localhost", "root", "yutong", "hamster1");
$classics = array("localhost", "root", "yutong", "classics");
$tcm_info = array("localhost", "root", "yutong", "tcm_info");
$tcmlm = array("localhost", "root", "yutong", "tcmlm");

$dbs = array("tcmlm" => $tcmlm, "tcmls" => $tcmls,  "clan" => $classics, "tcm_info" => $tcm_info);
$db_labels = array("tcmlm" => "TCMLM示范性文献库", "tcmls" => "TCMLS示范性文献库",  "clan" => "示范性中医古籍文献库",   "tcm_info" => "中医药信息学文献库");
$db_descs = array("tcmlm" => "该文献库采用“中医药文献元数据（TCMLM）”规范对二十多本中医古籍进行了示范性标注，用于演示TCMLM的应用效果和使用方法。", "tcmls" => "该文献库是以中医药学语言系统（TCMLS）为检索词，从万方文献库中检出的文献所构成的，用于演示TCMLS在文献检索和知识发现方面的作用。",  "clan" => "该文献库中包含《医学纲目》等中医古籍文献，用于演示“中医古籍语言系统”在中医古籍文献检索和文本语义关系发现方面的作用。", "tcm_info" => "汇集中医药信息学领域的文献。");
$db_search_words = array("tcmlm" => array( "内经", "肘后备急方", "丹溪心法", "本草纲目", "补遗雷公炮制", "李时珍", "本草", "刻本", "善本" ), "tcmls" => array("柴胡", "丹参", "白花蛇舌草", "人参", "板蓝根", "党参", "三仁汤", "山药", "当归", "四君子汤", "大黄"),  "clan" => array("柴胡"), "tcm_info" => array("柴胡"));
?>
