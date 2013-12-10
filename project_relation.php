<?php
include_once ("./header.php");

if (isset($_GET['example'])) {
    include_once ($_GET['example'] . ".php");
} else {
    ?>
    <div class="container">



        <!-- Jumbotron -->
        <div class="jumbotron">
            <h3>中国中医科学院自主选题研究项目</h3>
            <h1>基于文本的中医药语义关系发现研究</h1>
            <p class="lead">通过一些相对简单但较为完整的中医临床案例，分析中医辨证论治的思维过程，探讨基于本体推理和问答系统来支持中医临床决策的方法。</p>
            <p><a class="btn btn-lg btn-success" href="ontologies/spleen-1.0.owl" role="button"><span class="glyphicon glyphicon-download"></span>&nbsp;下载本体</a>
            <a class="btn btn-lg btn-primary" href="docs/spleen.docx" role="button"><span class="glyphicon glyphicon-download"></span>&nbsp;下载技术报告</a></p>
        </div>
      
        <div class="row">
            <div class="col-lg-4">
                <h2><a>从文本中发现语义关系</a></h2>   
                <p>用户可通过输入关键词来检索所发现的语义关系。下面是一些例子：</p>
                <?php
                $symptom_lists = array('虚证','右归丸 阳虚证');
                echo '<ol>';
                foreach ($symptom_lists as $symptom_list){
                    echo '<li>';
                    echo '<a target="_blank" href="http://localhost/docs/relation_manager.php?keywords=' . $symptom_list . '&submit=&question_type=症状">' . $symptom_list . '</a>';
                    echo '</li>';                
                }
                echo '</ol>';
                ?>         
                <p><a class="btn btn-primary" href="http://v3.bootcss.com/examples/justified-nav/#" role="button">查看详情 »</a></p>
            </div>
            <div class="col-lg-4">
                <h2><a>中医证候信息问答</a></h2>
                <p>当用户输入证候名称时，系统输出证候的治法等信息。下面是一些例子：</p>
                <?php
                
                $syndromes = array('肝气犯胃证', '肺脾气虚证', '脾胃虚寒证', '胃阴虚证', '脾肾两虚证', 
                    '脾肾阳虚证','心脾不足证', '肝胃不和证','外邪犯胃证','饮食伤胃证','饮食内停证','心脾不足证','土败木贼证','阳虚水泛证',
                    '湿热中阻证','湿热阻胃证','瘀血内结证','瘀血停胃证','寒邪客胃证','痰气交阻证','痰湿中阻证'
                    );
                $syndrome_links = array();
                foreach ($syndromes as $syndrome){   
                    array_push($syndrome_links, 
                     '<a target="_blank" href="qa.php?db_name=spleen&keywords=' . $syndrome . '&submit=&question_type=证候">' . $syndrome . '</a>');
                }
               
                
                echo '<p>';
                echo implode(';&nbsp;', $syndrome_links);
                echo '</p>';   
                ?>
                <p><a class="btn btn-primary" href="http://v3.bootcss.com/examples/justified-nav/#" role="button">查看详情 »</a></p>
            </div>
            <div class="col-lg-4">
                <h2><a>中医疾病信息问答</a></h2>
                <p>当用户输入疾病名称时，系统输出疾病的治法等信息。下面是一些例子：</p>
                
                <?php
                
                $diseases = array('痰饮', '消渴', '胃痛', '虚劳', '黄疸', '肥胖', 
                    '泄泻', '不寐', '中风', '便秘', '吐血', '多寐', '头痛', '尿血', 
                    '感冒', '痢疾', '痴呆', '眩晕', '紫斑', '腹痛', '遗精', '郁证',
                    '阳痿', '颤证', '黄疸', '鼓胀', '鼻衄', '齿衄');
                $disease_links = array();
                foreach ($diseases as $disease){   
                    array_push($disease_links, 
                     '<a target="_blank" href="qa.php?db_name=spleen&keywords=' . $disease . '&submit=&question_type=疾病">' . $disease . '</a>');
                }          
                
                echo '<p>';
                echo implode(';&nbsp;', $disease_links);
                echo '</p>';   
                ?>
                <p><a class="btn btn-primary" href="<?php echo $_SERVER['PHP_SELF'] . '?example=formula'; ?>" role="button">查看详情 »</a></p>
            </div>
        </div>
        <hr>
    </div> <!-- /container -->

    <?php
}
include_once ("./foot.php");
?>