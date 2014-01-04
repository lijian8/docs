<?php
include_once ("./header.php");
?>
<div class="container">
    <img width ="100%" src ="img/tcmls_text_mining.jpg"></img>    
    <div  class="container">
        <p class="lead"><strong>项目介绍</strong></p>        
        <p>中医药学语言系统是中国中医科学院中医药信息研究所于2002年起开始研制的一项大型中医药术语系统，语义网络是语言系统的重要组成部分。为了促进中医药学语言系统的发展，提高系统中语义关系的准确性，本课题拟进行基于文本的中医药语义关系发现研究，以求通过对中医药文献的文本进行分析，并与中医药学语言系统现有语义网络结合，得到准确的语义关系。</p>
        <p>在本项目中，我们主要完成了3项工作：
        <ol>
            <li>基于TCMLS从文本中抽取语义关系，构成了一个“文献库”；</li>                
            <li>从“文献库”和TCMLS中，分别归纳出基于语义类型的语义网络(即“顶层语义网络”)，并对这两个网络进行比较。</li>  
        </ol> 
        在此主要讨论第一项工作，关于第二项工作的讨论在&nbsp;<a href="/LOD/doc_tcmls_text_mining.php">这里&nbsp;》</a>
        </p>
        <hr>
        <p class="lead"><strong>从万方知识服务平台获取文献资源</strong></p> 
        <p>我们以TCMLS中的词汇作为关键词，从“万方数据知识服务平台”中检出了217667万篇文献题录，存入一个MySQL数据库中，构成“中医药文献库”。在“中医药文献库”的基础上，实现了<a href="index.php?db=tcmls">基于Web的文献检索系统</a>，支持基于关键词的文献检索功能。这样一个从万方数据知识服务平台中获取的中医药文献库，可以支持文本关系发现，文献标引等文本挖掘实验和文献检索应用，为后续工作奠定了基础。
            <a href="docs/于彤-基于文本挖掘发现中医药语义关系的方法探索研究-2013.12.27.docx" role="button">[详见技术报告]</a></p>
        <hr>
        <p class="lead"><strong>基于TCMLS的中医药文献分词处理</strong></p> 
        <p>本项目采用TCMLS作为词库，对中医药文献进行了分词处理。所提取的关键词属于中医药领域，为后续处理提供了噪音较少的数据源，提高了语义信息的质量，减少了无关信息。
            分词处理就是将“... 人参有‘补五脏、安精神、定魂魄、止惊悸、除邪气、明目开心益智’的功效...”的文本，拆分为类似于“人参 | 有 | 补 | 五脏 | 安 | 精神 | 定 | 魂 | 魄 | 止 | 惊悸 | 除 | 邪气 | 明 | 目 | 开 | 心 | 益 | 智 | 的 | 功 | 效 |”的序列。
            在分词处理中，用到了两个词库：其一是中医药领域专业词库，来源于TCMLS；其二是从中文动词中筛选出的谓词词表，用于推测语义关系的类型。
            <a href="docs/于彤-基于文本挖掘发现中医药语义关系的方法探索研究-2013.12.27.docx" role="button">[详见技术报告]</a>
        </p>
        <hr>
        <p class="lead"><strong>文本语义关系发现方法</strong></p> 
        <p>我们以TCMLS作为关键词，从“中医药文献库”中挖出了87826条关系 <a href="docs/于彤-基于文本挖掘发现中医药语义关系的方法探索研究-2013.12.27.docx" role="button">[具体方法详见技术报告]</a>。如下图所示，本项目还开发了一套<a href="relation_manager.php">文本语义关系的检阅系统</a>，支持用户完成文本语义关系的检阅、分析和标注工作，查看文本语义关系的文献依据和相关网页（借助Baidu搜索结果），并将文本语义关系正式插入某个术语系统（如TCMLS）。
        </p>
        <p align="center">
            <a href="relation_manager.php?keywords=脾虚+湿热证">
                <img src="img/脾虚湿热证1.jpg" width="60%"  alt="...">
            </a> 
        </p>
        <p>下面举一些关系检索的例子：</p>
        <ul class="nav nav-pills">
            <li><a href="relation_manager.php?keywords=心">心</a></li>
            <li><a href="relation_manager.php?keywords=肝">肝</a></li>
            <li><a href="relation_manager.php?keywords=脾">脾</a></li>
            <li><a href="relation_manager.php?keywords=肺">肺</a></li>
            <li><a href="relation_manager.php?keywords=肾">肾</a></li>
            <li><a href="relation_manager.php?keywords=胆">胆</a></li>            
            <li><a href="relation_manager.php?keywords=虚火">虚火</a></li> 
            <li><a href="relation_manager.php?keywords=脾虚">脾虚</a></li>
            <li><a href="relation_manager.php?keywords=心悸">心悸</a></li>
            <li><a href="relation_manager.php?keywords=耳鸣">耳鸣</a></li>                     
            <li><a href="relation_manager.php?keywords=血瘀">血瘀</a></li>
            <li><a href="relation_manager.php?keywords=流涕">流涕</a></li>         
            <li><a href="relation_manager.php?keywords=喷嚏">喷嚏</a></li>    
            <li><a href="relation_manager.php?keywords=消渴">消渴</a></li>
            <li><a href="relation_manager.php?keywords=感冒">感冒</a></li>
            <li><a href="relation_manager.php?keywords=人参">人参</a></li>
            <li><a href="relation_manager.php?keywords=地黄">地黄</a></li>  
            <li><a href="relation_manager.php?keywords=肝脏">肝脏</a></li>  
            <li><a href="relation_manager.php?keywords=湿热证">湿热证</a></li>
            <li><a href="relation_manager.php?keywords=肝肾阴虚">肝肾阴虚</a></li>    
            <li><a href="relation_manager.php?keywords=阴阳两虚">阴阳两虚</a></li> 
            <li><a href="relation_manager.php?keywords=阴虚火旺">阴虚火旺</a></li>  
            <li><a href="relation_manager.php?keywords=四君子汤">四君子汤</a></li>
            <li><a href="relation_manager.php?keywords=足三阴经">足三阴经</a></li>
            <li><a href="relation_manager.php?keywords=三阴交穴">三阴交穴</a></li>
            <li><a href="relation_manager.php?keywords=六味地黄">六味地黄</a></li>            
            <li><a href="relation_manager.php?keywords=寒凝血瘀证">寒凝血瘀证</a></li>      
            <li><a href="relation_manager.php?keywords=肝郁脾虚证">肝郁脾虚证</a></li> 
            <li><a href="relation_manager.php?keywords=补中益气丸">补中益气丸</a></li>    
             <li><a href="relation_manager.php?keywords=蛇胆川贝液">蛇胆川贝液</a></li>    
            
        </ul>
        <p>当用户在“语义关系检索界面”中点击查看某条关系，系统就会跳转到这条语义关系的展示和处理界面。在语义关系的展示和处理界面中，用户可以查看这条关系的主体信息、候选谓词、客体信息、以及参考性参数。
            其中，对于主体和客体，都给出了概念的类型、正名、定义以及概念信息页面的链接。
            候选谓词是基于TCMLS中的用法来生成的，例如，若主体为“人参”，客体为“肾阳虚证”，则系统会推荐“治疗”作为候选谓词。
            用户可以点击“文献资源”，查看该语义关系所出自的文献。对于每篇文献，系统都给出了题名和摘要。用户单击选择某篇文献的题名时，系统会跳转到该文献的题录信息页面。
        </p>

        <p align="center">
            <a href="relation.php?id=15436">
                <img src="img/脾虚湿热证2.jpg" width="60%"  alt="...">
            </a> 
        </p>
        <p>下面举一些文本语义关系的例子：</p>
        <ul class="nav nav-pills">
            <li><a href="relation.php?id=15436">脾虚+湿热证</a></li>
            <li><a href="relation.php?id=19169">脾气虚+参苓白术散</a></li>
            <li><a href="relation.php?id=22346">脾气虚+消瘦</a></li>
            <li><a href="relation.php?id=45169">灵芝+担子菌亚门</a></li> 
            <li><a href="relation.php?id=40490">人参+四君子汤</a></li>  
            <li><a href="relation.php?id=46778">肝郁脾虚证+木香顺气丸</a></li> 
            <li><a href="relation.php?id=40429">感冒+湿热</a></li> 
            <li><a href="relation.php?id=81052">湿热+肝郁脾虚证</a></li> 
            <li><a href="relation.php?id=85484">阴阳两虚+虚证</a></li>    
            <li><a href="relation.php?id=86794">足三阴经+三阴交穴</a></li> 
            <li><a href="relation.php?id=26799">气滞+阴虚火旺</a></li> 
            <li><a href="relation.php?id=72263">气滞+胃痛</a></li>
            <li><a href="relation.php?id=82118">气逆+气滞</a></li>
            <li><a href="relation.php?id=52607">血瘀证+脾虚</a></li>
            <li><a href="relation.php?id=85726">表证+寒凝血瘀证</a></li>
            <li><a href="relation.php?id=49933">流涕+喷嚏</a></li>      
            <li><a href="relation.php?id=52965">心悸+耳鸣</a></li>  

        </ul>
        <hr>
        <p class="lead"><strong>总结</strong></p>
        <p>本项目向术语专家提供新的技术能力，主要包括从语义关系中归纳“顶层语义网络”的技术能力，以及向术语专家提供从文本中发现新颖语义关系的技术能力。这项工作尚存在一些局限性。例如，我们尚缺乏判断文本语义关系准确类型的有效手段，也尚未实现发现新词的方法。另外，有些中医药领域的词汇尚未收入TCMLS之中，这影响了语义关系发现的效果。</p>
        <br>
        <p align="center">
            <a class="btn btn-lg btn-success" href="docs/文本语义关系平台用户手册v2.docx" role="button"><span class="glyphicon glyphicon-download"></span>&nbsp;下载用户手册</a>
            <a class="btn btn-lg btn-primary" href="docs/于彤-基于文本挖掘发现中医药语义关系的方法探索研究-2013.12.27.docx" role="button"><span class="glyphicon glyphicon-download"></span>&nbsp;下载技术报告</a>
        </p>
        <hr>
    </div>
</div> <!-- /container -->

<?php
include_once ("./foot.php");
?>