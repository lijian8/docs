<?php
include_once ("./header.php");
?>
<div class="container">

    <?php
    $page_name = 'introduction';
    include_once ("./classics_header.php");
    ?>

    <div class = "panel panel-default">
        <div class = "panel-body">
            <div class="container">
                <h3><font face="微软雅黑"><strong>项目介绍</strong></font></h3>   
                <hr>
                <p>
                    语言系统建立是为解决因为概念表述方式不统一和相关信息分散而造成的检索盲区。对于以古籍为记载形式的中医药理论知识而言，其重要性更不言而喻。
                    经前期研究，中医古籍语言系统已初步完成框架建设，但传统中医学术内涵丰富、规模庞大，决定其必然是一项长期工作，尤其是语义类型、语义关系需不断调整完善，才能更好、更全面地反映中医学术本质内涵。
                </p>
                <p>
                    本研究以较有代表性的综合医著《医学纲目》为试验文本，在基于N-最短路径中文词语粗分的基础上进行以关键谓语动词为驱动的文本语义关系及相关实体词的抽取，
                    修订与完善古籍语言系统的语义关系，建立古今语义关系对照表，为古籍语言系统的完善提供路径，为建立古籍知识体系的语义网络，实现知识点的链接，实现中医古籍知识的共享和重用奠定基础。
                </p>
                <p align="center">
                    <a class="btn btn-lg btn-success" href="docs/文本语义关系平台用户手册v2.docx" role="button"><span class="glyphicon glyphicon-download"></span>&nbsp;下载用户手册</a>
                    &nbsp;&nbsp;
                    <a class="btn btn-lg btn-primary" href="docs/于彤-基于文本挖掘发现中医药语义关系的方法探索研究-2013.12.27.docx" role="button"><span class="glyphicon glyphicon-download"></span>&nbsp;下载技术报告</a>
                </p>
            </div>
        </div>
    </div>
    <div class = "panel panel-default">
        <div class = "panel-body">
            <div class="container">
                <h3><font face="微软雅黑"><strong>研究目标</strong></font></h3>   
                <hr>
                <ul >
                    <li>实现基于关键动词的中医古籍概念实体间语义关系的半自动抽取</li>
                    <li>建立古今语义关系对照表</li>
                </ul>        
            </div>
        </div>
    </div>
    <div class = "panel panel-default">
        <div class = "panel-body">
            <div class="container">
                <h3><font face="微软雅黑"><strong>研究内容</strong></font></h3>              
                <hr>
                <ul >
                    <li>基于N-最短路径方法的中文词语粗分法进行《医学纲目》的分词: 
                        本课题拟选用综合性医著《医学纲目》作为试验文本，利用已经开发完成的中医古籍分词工具进行《医学纲目》的分词研究，对其中的高频词给予关注，为《医学纲目》领域概念术语的提取奠定基础，为匹配关键动词的相关主语宾语提供支持。
                    </li>
                    <li>根据语言学特性和专业知识自拟出关键动词: 
                        根据语言学特性和专业知识阅读训练样本，以中医古籍语言系统以及传统针灸知识本体现有语义关系为参照，自拟出关键动词，其可以用来提示实体间的语义关系，进而挖掘出与动词共现的实体。如“疗”“主”等等中医古籍特有的表示语义关系的关键动词。
                    </li>
                    <li>基于文本信息抽取技术识别论元，判别语义关系: 
                        提取古文相关句法规则，以关键动词为基准，结合TCMLS和中医古籍语言系统的词典，完成文本信息抽取，匹配与关键动词相关的语义类型，如中药、疾病等作为“疗”关系的候选主语和宾语，识别论元（谓语动词前后的主语和宾语），最后经过语义验证生成能够正确表明实体之间的语义关系的述谓结构。
                    </li>
                    <li>建立古今语义关系对照表: 
                        根据古今语义关系内涵之分别，建立对照表，规范语义关系，为古籍语言系统和中医药学语言系统的构建完善奠定基础。
                    </li>
                </ul>  
            </div>
        </div>
    </div>

    <div class = "panel panel-default">
        <div class = "panel-body">
            <div class="container">


                <h3><font face="微软雅黑"><strong>技术研发和系统实现</strong></font></h3>  
                <hr>
                <p>文本知识发现的主要目标，是从中医药文献中自动提取实体和语义关系。
                    我们采用文本信息提取技术，实现了“中医古籍文本语义关系提取软件系统”。
                    该系统基于中医古籍语言系统，对《医学纲目》等中医古籍进行处理，自动识别其中出现的中医概念和实体，生成文本内容的索引。
                    该系统还实现了从文本中自动发现语义关系的功能。该系统从中医药文献中找出在一起频繁出现的词对，基于中医古籍语言系统判断语义关系的性质，
                    再将所发现的语义关系交由领域专家进行检验。该系统提供文本语义关系管理界面，对从文献中的语义关系进行集中管理、浏览和加工。
                    这套文本语义关系发现和检阅系统，向术语专家提供从文本中发现新颖语义关系的技术能力。下面进行具体介绍。
                </p>
                <hr>
                <p class="lead">将《医学纲目》存入一个文献型数据库</p> 
                <p>本研究以较有代表性的综合医著《医学纲目》为试验文本，开展文本信息提取和语义关系发现研究。《医学纲目》系综合性医书，楼英编撰。嘉靖四十四年(1565)，曹灼予以刊行。全书共40卷，分11部，以阴阳脏腑分病为纲。我们将经过校对的《医学纲目》文本<a href="docs/医学纲目-标引-校对.doc" role="button">【点击下载原文】</a>存入数据库<a  href="docs/医学纲目文献库_utf8.csv" role="button">【点击下载数据文件】</a>中，用于进一步的处理<a href="#" role="button">【详见技术报告】</a>。</p>

                <hr>
                <p class="lead">基于"中医古籍语言系统"的文本信息提取</p> 
                <p> 
                    我们基于“中医古籍语言系统”，对《医学纲目》等中医古籍进行了处理，自动识别其中出现的中医概念和实体，生成文本内容的索引。
                    我们进一步以"中医古籍语言系统"作为关键词，从文本中找出在一起频繁出现的词对，并根据“中医古籍语言系统”判断语义关系的性质，从“医学纲目”中挖出了60048条语义关系，再将所发现的语义关系交由领域专家进行检验 <a href="docs/于彤-基于文本挖掘发现中医药语义关系的方法探索研究-2013.12.27.docx" role="button">
                        【具体方法详见技术报告】</a>。
                </p>
                <hr>
                <p class="lead">查看中医古籍的语义关系</p>
                <p>
                    如下图所示，该系统列出了中医古籍的语义关系（包括：位于、治疗、穿过、实施、影响、导致、干扰、管理、现象表达、等同关系、包围、产生、包含、时间上相关、具有……特性、与……相邻、与……相连、
                    汇合、与……同时发生、诊断、概念上对应、组成、测量、被干扰、被治疗、禁止使用、证实、有……特性、归经、被导致、后于……发生、导致、被实施、被影响、控制、……测量值、被包含、与……相表里、与……对立、证实等），
                    并支持用户查看这些语义关系在中医古籍文本中的用法。例如，对于“位于”这一语义关系，系统给出了“位于”的定义，并列出了“位于”在中医古籍文本中所对应的术语
                    （如注、渗透、居、别而络、留于、布、聚于、结于、舍于、发于、溜于等）。
                </p>
                <p align="center">
                    <a href="relations.php">
                        <img src="img/relations-位于.jpg" width="60%"  alt="...">
                    </a> 
                </p>
                <p>
                    接下来，系统给出了语义关系及其所对应的术语在中医古籍中的应用实例（如下图所示）。例如，《医学纲目》中的术语“注”代表一种“位于”关系，其实例包括：
                <ul>
                    <li><strong>荣气&nbsp;&nbsp;注&nbsp;&nbsp;五脏六腑</strong>: ......荣气者，内注五脏六腑......</li>                                        
                    <li><strong>卫气&nbsp;&nbsp;注&nbsp;&nbsp;小指次指之间</strong>: ......故卫气之行，一日一夜五十周于身......注小指次指之间......</li>
                    <li><strong>肾&nbsp;&nbsp;注&nbsp;&nbsp;心</strong>: ......肾注于心，心注于肺，肺注于肝，肝注于脾，脾复注于肾为周......</li>        
                </ul>                       
                用户可点击查看相关文本的全文。
                </p>
                <p align="center">
                    <a href="relations.php">
                        <img src="img/relations-注.jpg" width="60%"  alt="...">
                    </a> 
                </p>
                <hr>
                <p class="lead">对中医古籍进行标注</p>
                系统支持用户以计算机辅助的方式对中医古籍的文本内容进行语义标注。如下图所示，系统在左侧列出古籍文本，在右侧则列出从文本中提取的概念和语义关系。用户可对古籍进行编辑，并对其中蕴含的
                概念和语义关系进行修改。
                <p align="center">
                    <a href="annotation.php?text_id=827">
                        <img src="img/中医古籍标注.jpg" width="60%"  alt="...">
                    </a> 
                </p>
                <hr>
                <p class="lead">查看经过标注的中医古籍全文</p>       
                <p>该系统并以网页的形式展示古籍全文，以不同的颜色标出文本中出现的中医名称和谓词。它还在文本右侧列出相关概念，用户可点击查看概念定义。另外，系统还找出文中出现的谓词，据此识别文中出现的语义关系。如下图所示，用户也可以点击查看原文中蕴含的语义关系。</p>
                <p align="center">
                    <a href="book.php">
                        <img src="img/医学纲目.jpg" width="60%"  alt="...">
                    </a> 
                </p>   
                <hr>
                <p class="lead">对从文本中发现的语义关系进行集中管理</p>
                <p>如下图所示，我们开发了一套文本语义关系管理与检阅系统，对从文本中发现的语义关系进行集中管理，支持用户完成文本语义关系的检阅、分析和标注工作，
                    查看文本语义关系的文献依据和相关网页（借助Baidu搜索结果），并将文本语义关系正式插入某个术语系统（如"中医古籍语言系统"）。下面举一些检索词供参考： 
                    <!--<ul class="nav nav-pills">-->
                    <?php
                    $keywords = array("心", "肝", "脾", "肺", "肾", "胆", "血", "虚", "脾虚", "心悸", "耳鸣", "消渴", "感冒", "地黄", "人参", "大金花丸");
                    foreach ($keywords as $keyword) {
                        //echo '<li><a target="_blank" href="relation_manager.php?db_name=clan&keywords=' . $keyword . '">' . $keyword . '</a></li>';
                        echo '<a target="_blank" href="relation_manager.php?db_name=clan&keywords=' . $keyword . '">"' . $keyword . '"</a>&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    ?>                      
                    <!--</ul>-->
                    。</p>
                <p align="center">
                    <a href="relation_manager.php?db_name=clan&keywords=肾">
                        <img src="img/clan_relation_list_肾.jpg" width="60%"  alt="...">
                    </a> 
                </p>


                <p>
                    当用户在“语义关系检索界面”中点击查看某条关系，系统就会跳转到这条语义关系的展示和处理界面。在语义关系的展示和处理界面中，用户可以查看这条关系的主体信息、候选谓词、客体信息、以及参考性参数。
                    其中，对于主体和客体，都给出了概念的类型、正名、定义以及概念信息页面的链接。
                    候选谓词是基于TCMLS中的用法来生成的，例如，若主体为“人参”，客体为“脾虚”，则系统会推荐“治疗”作为候选谓词。用户可以点击“文献资源”，查看该语义关系所出自的文本。
                    下面举一些文本语义关系的例子：

                    <!--<ul class="nav nav-pills">-->
                    <?php
                    $relations = array(
                        "肾水+腰脊" => "relation.php?db_name=clan&id=63975",
                        "脾气虚+腹胀" => "relation.php?db_name=clan&id=67809",
                        "大金花丸+肺痿" => "relation.php?db_name=clan&id=69239",
                        "胃寒+胃气虚" => "relation.php?db_name=clan&id=63975",
                        "干呕+白通加猪胆汁汤" => "relation.php?db_name=clan&id=68510",
                        "人参+脾虚" => "relation.php?db_name=clan&id=68073",
                        "心悸+二陈汤" => "relation.php?db_name=clan&id=87089",
                        "气逆+呕血" => "relation.php?db_name=clan&id=62715"
                    );
                    foreach ($relations as $relation => $uri) {
                        //echo '<li><a href="' . $uri . '">' . $relation . '</a></li>';
                        echo '<a href="' . $uri . '">"' . $relation . '"</a>&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    ?>                  
                    </ul>
                    。</p>
                <p align="center">
                    <a href="relation.php?db_name=clan&id=120097">
                        <img src="img/clan_relation_三焦主持诸气.jpg" width="60%"  alt="...">
                    </a> 
                </p>            


            </div>
        </div>
    </div>
</div>

<?php
include_once ("./foot.php");
?>