<?php
include_once ("./header.php");

require 'vendor/autoload.php';
require_once "html_tag_helpers.php";

include_once ("./rdf_helper.php");


function render_thing($o) {
    $label = get_label($o);
    if (!($o->isBnode())) {
        echo "&nbsp;<a href='#" . $o->localname() . "'>" . $label . "</a>&nbsp;";
    }
}

function render_matching_values($graph, $me, $property) {
    $rp = $graph->resource($property);
    foreach ($graph->resourcesMatching($rp, $me) as $r) {
        render_thing($r);
    }
}

function render_property_values($graph, $me, $property) {
    $property = $graph->resource($property);

    foreach ($me->all($property) as $o) {
        render_thing($o);
    }
}

$graph = new EasyRdf_Graph("http://localhost/lod/tcmls-sn.rdf");
$graph->load();
?>
<div class="container">
    <ol class="breadcrumb">
        <li><a href="#">首页</a></li>
        <li><a href="#">本体</a></li>
        <li class="active">TCMLS-SN本体规范</li>
    </ol>
    <h1>TCMLS-SN本体规范</h1>
    <table class="table">
        <tbody>
            <tr>
                <td width='10%'><strong>当前版本：</strong></td>
                <td>http://lod.cintcm.com/LOD/ontology.php</td>
            </tr>
            <tr>
                <td width='10%'><strong>最新版本：</strong></td>
                <td>http://lod.cintcm.com/LOD/ontology.php</td>
            </tr>
            <tr>
                <td width='10%'><strong>版本号：</strong></td>
                <td>1.00</td>
            </tr>
            <tr>
                <td width='10%'><strong>上次更新：</strong></td>
                <td>2013-10-06</td>
            </tr>
            <tr>
                <td width='10%'><strong>编辑：</strong></td>
                <td>于彤</td>
            </tr>
            <tr>
                <td width='10%'><strong>作者：</strong></td>
                <td>于彤</td>
            </tr>
            <tr>
                <td width='10%'><strong>贡献者：</strong></td>
                <td>详见<a href="#sec-ack">致谢</a></td>
            </tr>
              <tr>
                <td width='10%'><strong>建模技术：</strong></td>
                <td>TCMLS-SM本体基于RDF和OWL技术实现，它们是由W3C提出的开放性技术规范。</td>
            </tr>
            
            
        </tbody>        
    </table>


   
    
    <hr>
    <h2>摘要</h2>
    <p>TCMLS-SN本体为“中医药学语言系统的语义网络框架(TCMLS Semantic Network)”的OWL/RDF版本。中医药学语言系统（TCMLS）旨在实现规范化、一体化的中医药术语体系，以支持中医药文献与数据资源的合理组织和有效检索。“Health informatics--Semantic network framework of traditional Chinese medicine language system [ISO/DTS 17938]”（健康信息学—中医药学语言系统的语义网络框架）是国际标准化组织（ISO）于近期完成、正在审核的技术规范草案。它作为一个面向中医药领域的规范化顶层本体，为中医药学语言系统中的所有概念提供了一体化的概念框架，对于中医药学语言系统的规范化和国际化具有重要意义。</p>
    <hr>
    <h2>关于本文</h2>
    本文为一份不断完善的文档。它是通过运行一份PHP脚本而自动生成的，将TCM-SM OWL本体与术语说明文档的内容综合呈现出来。 
    <h2>目录</h2>
    <ul>
        <li><a href="#sec-intro">1. 介绍</a>
            <ul>
                <li><a href="#sec-notation">1.1. 术语</a></li>
            </ul>
        </li>
        <li><a href="#sec-glance">2. TCMLS-SN概览</a></li>
        <li><a href="#sec-vocab">3. TCMLS-SN本体描述</a>
            <ul>
                <li><a href="#sec-example">3.1. 例子</a></li>
                <li><a href="#sec-background">3.2. 背景</a></li>
                <li><a href="#sec-evolution">4.1. TCMLS-SN的更新和扩展</a></li>
                <li><a href="#sec-modules">4.2. TCMLS-SN的模块</a></li>
                <li><a href="#sec-standards">4.3. TCMLS-SN的相关标准</a></li>
                <li><a href="#sec-sioc-rdf">4.4. TCMLS-SN和RDF</a></li>
            </ul>
        </li>
        <li><a href="#sec-xref">4. TCMLS-SN的类和属性列表</a></li>
        <li><a href="#sec-external">5. 外部类和属性</a></li>
        <li><a href="#sec-ack">6. 致谢</a></li>
        <li><a href="#sec-conclusion">7. 小结</a></li>        
        <li><a href="#sec-reference">8. 参考文献</a></li>
        <li><a href="#sec-changes">9. 变更记录</a></li>
    </ul>
    <hr>
    <h2><a name="sec-intro" id="sec-intro"></a>1. 介绍</h2>
    <p>造成中医药SN系统不规范的根源在于缺乏一套业界共同认可并实施的技术规范。由于中医药语言体系相当庞杂，涉及知识面甚广，
        中医术语规范化工程需要在多人协同共建的基础上完成，依赖于多个专家团体、组织机构和项目之间的协作。
        编辑人员在设计理念和表达方法上的差异，造成系统内部的不一致和系统之间的异构性。
        编辑人员的理解偏差和操作失误，又在系统中引入了较多的缺陷和错误。为解决这些问题，需要建立中医药SN系统的规范体系，并在实际工程中加以实施。
    </p>
    <p>
        中医团体已开展了相关技术规范的研制工作。早在2003年，尹爱宁等就提出了《中医药一体化语言系统》的技术标准，对TCMLS的收词原则、
        语义类型和语义关系进行了规范。但该标准的适用范围仅限于TCMLS系统，“温病学本体”、“针灸学语义网络”、 “中医古籍语言系统”
        等系统都不符合这套标准，由此造成同类系统之间的异构性。可见，为使一套技术规范具有广泛的影响力和约束力，需要在权威性标准化组织的框架下开展工作。
        鉴于此，IITCM于2008年代表我国向国际标准化组织（ISO）提出了技术规范“Health informatics -- 
        Semantic network framework of traditional Chinese medicine language system[ISO/DTS 17938]”的项目提案。
        该项目于2012年得到成功立项，这是我国中医药信息标准化项目在ISO中首次成功立项，具有突破性意义。
        该技术规范已于2013年3月形成草案，并进入评审和投票环节。
    </p>
    <h2><a name="sec-glance" id="sec-glance"></a>2. TCMLS-SN概览</h2>
    <p>目前，在TCMLS-SN这一OWL本体中，定义了&nbsp;<span class="badge"><?php echo num_of_instances($graph, 'owl:Class'); ?></span>个类（owl:Class）和&nbsp;<span class="badge"><?php echo num_of_instances($graph, 'owl:ObjectProperty'); ?></span>&nbsp;个对象属性（owl:ObjectProperty）：</p>
    <div class="well">
        <?php
        echo '<p>类&nbsp;<span class="badge">' . num_of_instances($graph, 'owl:Class') . '</span>：&nbsp;|';
//list_instances($graph, 'owl:Class');
        foreach ($graph->allOfType('owl:Class') as $p) {
            if (!($p->isBnode())) {
                echo "&nbsp;" . link_to(get_label($p), '#' . $p->localname()) . "&nbsp;|";
            }
        }
        echo '</p>';

        echo '<p>对象属性&nbsp;<span class="badge">' . num_of_instances($graph, 'owl:ObjectProperty') . '</span>：&nbsp;|';
//list_instances($graph, 'owl:ObjectProperty');
        foreach ($graph->allOfType('owl:ObjectProperty') as $p) {
            if (!($p->isBnode())) {
                echo "&nbsp;" . link_to(get_label($p), '#' . $p->localname()) . "&nbsp;|";
            }
        }
        echo '</p>';
        ?>
    </div>
    <h2><a name="sec-vocab" id="sec-vocab"></a>3. TCMLS-SN描述</h2>


    <p>该ISO技术规范草案的核心内容是一个中医药领域的规范化顶层本体（Upper-Level Ontology），即TCMLS Semantic Network。如图1所示，TCMLS Semantic Network包括“语义类型（Semantic Type）”和“语义关系（Semantic Relation）”两大部分，其中语义类型对应网络节点，语义关系对应节点之间的弧。
    </p>
    <div class="col-sm-12 col-md-12">
        <div align="center" class="thumbnail">
            <img src="./img/tcmls/语义网络.jpg" alt="...">
            <div class="caption">
                <p><strong>图1.</strong>&nbsp;“中医药学语言系统的语义网络框架”的局部示意图</p>
            </div>
        </div>
    </div>

    <p>
        TCMLS Semantic Network列举了中医药领域中最基本的96种语义类型，并对其进行了定义和限定。这些语义类型的来源包括：（1）来自中医药领域的特色概念，如Viscera（脏腑）、Meridian and collateral（经络）、Acupuncture point（腧穴）等；（2）从其他领域中引入中医药领域的概念，如ToxinTCM（毒性）（这些术语被标上“TCM”，以示区别）；（3）相关的通用概念，如Medicinal substance（药用物质）。TCMLS Semantic Network定义了语义类型之间的等级关系，例如“治法属于中医治疗”、“中药疗法属于治法”等。在最顶层，语义类型被分为“Entity（实体）”和“Events（事件）”两大类，其中Entity（实体）被定义为“A broad type for grouping physical and conceptual entities（用于对物理和概念实体进行分组的广义类型）”；Events（事件）被定义为“A broad type for grouping activities, processes and states（用于对活动、过程和状态进行分组的广义类型）”。该模型为TCMLS提供了一个分类架构，可以对TCMLS中的每个概念赋予明确的语义类型。
    </p>
    <div class="col-sm-12 col-md-12">
        <div class="thumbnail">
            <img  src="./img/tcmls/语义类型.jpg" alt="...">
            <div align="center" class="caption">
                <strong>图4.</strong>&nbsp;TCMLS-SN的语义类型
            </div>
        </div>
    </div>
    <p>TCMLS Semantic Network中还定义了58种基本的语义关系，用于建立TCMLS概念之间的逻辑关系。语义关系分为“Is_a（上下位关系）”和“Associated_with（相关关系）”两大类。其中，“Is_a（上下位关系）”是构建TCMLS概念层次结构的基础。在TCMLS中，每个概念必有一个（可有多个）上位概念。“Associated with”则表达两个概念之间对等的相关关系。TCMLS Semantic Network中定义了57种相关关系，它们分为“物理上相关”、“空间上相关”、“影响”、“时间上相关”、“概念上相关”等五大类。这些语义关系除了源于UMLS之外，还包括中医药领域的特色关系。例如，“Inter_exterior and interior with（相表里）”表达了脏腑以及经络之间的阴阳表里关系，反映的是脏腑经络功能上的相互影响；“Opening at（开窍于）”表达了五脏与五官之间的一个特殊关系，有经络相连（如肾开窍于耳，肝开窍于目等）。</p>
    <div class="col-sm-12 col-md-12">
        <div class="thumbnail">
            <img  src="./img/tcmls/语义关系.jpg" alt="...">
            <div align="center" class="caption">
                <strong>图5.</strong>&nbsp;TCMLS-SN的语义关系
            </div>
        </div>
    </div>
    <p>TCMLS Semantic Network中还通过语义关系将语义类型连接起来，为领域专家建立具体概念之间的语义关系提供参考和约束。以“中药”为核心的语义网络如图2所示， 该网络中包括一系列形如“Chinese medicinal，Treats，Pathological phenomena”、“Chinese medicinal therapy，uses，Chinese medicinal”的语义陈述，它们共同构成了“中药”这一概念的语义描述。TCMLS Semantic Network为中医药术语系统的规范化表达和规范化处理提供了顶层框架和依据，将在中医药术语系统的质量保证和国际推广工作中发挥关键作用。</p>

    <div class="col-sm-12 col-md-12">
        <div class="thumbnail">
            <img width="60%" src="./img/tcmls/中药语义网络.jpg" alt="...">
            <div class="caption" align="center">
                <strong>图2.</strong>&nbsp;以“中药”为核心的语义网络
            </div>
        </div>
    </div>

    <p>以“证候”为核心的语义网络:</p>
    <div class="col-sm-12 col-md-12">
        <div class="thumbnail">
            <img width="40%" src="./img/tcmls/证候语义网络.jpg" alt="...">
            <div align="center" class="caption">
                <strong>图3.</strong>&nbsp;以“证候”为核心的语义网络
            </div>
        </div>
    </div>
    <p> Semantic Network的研发过程中，学习并借鉴了UMLS和SNOMED CT等国际先进术语系统的设计理念和成功经验。例如，TCMLS Semantic Network借鉴了UMLS Semantic Network的构建模式和体系结构，并引用了后者中定义的部分语义类型和全部语义关系。但它是根据中医自身独特理论，以中医药知识体系为核心构建的，具有显著的中医特色，与UMLS Semantic Network等系统具有本质性区别。</p>

    <h2><a name="sec-xref" id="sec-xref"></a>4. TCMLS-SN的类和属性列表</h2>
    TCMLS-SN定义了如下的类和属性。欲知详情，请查看<a href="tcmdemoen.rdf">TCMLS-SN的OWL/RDF文件</a>.

    <?php
    foreach ($graph->allOfType('owl:Class') as $me) {
        if (!($me->isBnode())) {
            echo '<div class="well-sm" id="' . $me->localName() . '">';
            echo "<h3>类:&nbsp;<a href='individual.php?localname=" . $me->localName() . "'>" . $me->localName() . "</a></h3>";

            render_literals($graph, $me, 'rdfs:comment');
            echo "<table class=\"table table-bordered\"><tbody>";

            echo "<tr><td width='10%'>中文标签:</td><td>" . $me->label('zh') . "</td></tr>";
            echo "<tr><td>英文标签:</td><td>" . $me->label('en') . "</td></tr>";

            echo "<tr><td>父类:</td><td>";
            render_property_values($graph, $me, "rdfs:subClassOf");
            echo "</td></tr>";

            echo "<tr><td>子类:</td><td>";
            render_matching_values($graph, $me, "rdfs:subClassOf");
            echo "</td></tr>";

            echo "</tbody></table>";


            echo '<p style="float: right; font-size: small;">[<a href="#sec-glance">回到顶部</a>]</p>';
            echo '</div>';
        }
    }

    foreach ($graph->allOfType('owl:ObjectProperty') as $me) {
        if (!($me->isBnode())) {
            echo '<div class="well-sm" id="' . $me->localName() . '">';
            echo "<h3>对象属性:&nbsp;<a href='individual.php?localname=" . $me->localName() . "'>" . $me->localName() . "</a></h3>";

            render_literals($graph, $me, 'rdfs:comment');
            echo "<table class=\"table table-bordered\"><tbody>";

            echo "<tr><td width='10%'>中文标签:</td><td>" . $me->label('zh') . "</td></tr>";
            echo "<tr><td>英文标签:</td><td>" . $me->label('en') . "</td></tr>";

            echo "<tr><td>父属性:</td><td>";
            echo render_property_values($graph, $me, "rdfs:subPropertyOf");
            echo "</td></tr>";

            echo "<tr><td>子属性:</td><td>";
            render_matching_values($graph, $me, "rdfs:subPropertyOf");
            echo "</td></tr>";

            echo "</tbody></table>";


            echo '<p style="float: right; font-size: small;">[<a href="#sec-glance">回到顶部</a>]</p>';
            echo '</div>';
        }
    }
    ?>
    <h2><a name="sec-external" id="sec-external"></a>5. 外部类和属性</h2>
    <h2><a name="sec-ack" id="sec-ack"></a>6. 致谢</h2>
    <p>本文的视觉风格和文档结构，借鉴于Dan Brickley和Libby Miller的“FOAF Vocabulary Specification”，以及Uldis Bojārs和John G. Breslin的“SIOC Core Ontology Specification”。</p>
    <p>这项工作得到如下基金项目资助：中国中医科学院基本科研业务费自主选题项目(编号：ZZ060808)-“中医文献元数据标准、中医语言系统分类框架等国际标准研制”；中国博士后科学基金资助项目（编号：2012M520559）-“面向中医药复杂语义网络的方法学研究”；中国中医科学院基本科研业务费自主选题项目（编号：ZZ070311）-“中医药复杂语义网络模型研究”。
    </p>
    <h2><a name="sec-conclusion" id="sec-conclusion"></a>7. 小结</h2>
    <p>“中医药学语言系统的语义网络框架”是我国中医药信息学领域的技术规范在ISO中首次立项。
        在ISO这样一个西方文化影响下的国际组织中，开发具有中华文化特色的标准项目，需要跨越东、西方文化鸿沟，必将面临许多新问题、新挑战。
        这些问题不仅局限于规则和技术层面，也涉及到中医药语义网络的原理和方法学问题。
        若该技术规范最终得到通过和发表，则其成功经验和理论成果将对后续的中医药标准化项目产生示范和指导作用。
    </p>
    <h2><a name="sec-reference" id="sec-reference"></a>8. 参考文献</h2>
    <ol>  
        <li>	贾李蓉,杨硕,董燕,田野,刘丽红. 2012. 中医药学名词术语规范化现状[J]. 中国数字医学,7(4):2-4.
        </li>
        <li>
            Gruber TR. 2008. Ontology. Entry in the Encyclopedia of Database Systems, Ling Liu and M. Tamer Özsu (Eds.), Springer-Verlag.
        </li>
        <li> 	Sowa JF. 1987. Semantic Networks. In Encyclopedia of Artificial Intelligence, edited by Stuart C. Shapiro, Wiley.
        </li>
        <li> 	Miller GA. 1995. WordNet: a lexical database for English[J]. Communications of the ACM, 38(11), 39-41.
        </li>
        <li> 	McCray AT. 2003. An upper-level ontology for the biomedical domain[J]. Comparative and Functional Genomics, 4(1), 80-84.
        </li>
        <li> 	Stearns MQ, Price C, Spackman KA, Wang AY. 2001. SNOMED clinical terms: overview of the development process and project status. Proc AMIA Symp:662-6.
        </li>
        <li> 	尹爱宁,张汝恩.2003.建立《中医药一体化语言系统》[J].中国中医药信息杂志,10(3):90-91.
        </li>
        <li> 	Zhou X, Wu Z, Yin A, Wu L, Fan W, Zhang R. 2004. Ontology development for unified traditional Chinese medical language system[J]. Artificial Intelligence in Medicine, 32(1), 15-27.
        </li>
        <li>	贾李蓉,杨硕,董燕,田野,刘丽红. 2012. 中医药学语言系统评价体系的研究与建立[J].中国数字医学, 07(10):13-16.
        </li>
        <li> 	杨阳, 李园白, 崔蒙. 2007. 建立中医临床术语集探索性研究[J]. 中国中医药信息杂志, 13(12), 105-105.
        </li>
        <li> 	于琦,崔蒙,李园白,宓金华,梁欣颖,朱玲,刘丽红,田野,杨阳,李敬华,朱晓博,王静,张晶,奚怀平. 2012. 中医温病诊疗知识模型初探[J]. 中国中医药信息杂志, 19(10):18-20.
        </li>
        <li> 	朱玲,崔蒙. 2010a. 传统针灸知识体系语义网络的构建探讨[J].中国数字医学,5(5):47-49.
        </li>
        <li> 	朱玲,尹爱宁,崔蒙等. 2010b. 中医古籍语言系统构建的关键问题与对策[J].中国中医药信息杂志, 17(4):98-99.
        </li>
        <li> 	贾李蓉,刘丽红. 2012. 基于中医药学语言系统的文献检索服务平台[J]. 医学信息学杂志, 33(1):54-56.
        </li>
        <li> 	Ma J, Chen HJ. 2008. Semantic Network Analysis on TCM Language System. WSCS '08:43-48.
        </li>
        <li> 	张小刚. 2010. 基于中医药本体的语义关系发现及验证方法[D].浙江大学计算机学院.
        </li>
        <li> 	崔蒙,胡雪琴. 2010.中医药语言系统中的数据清洗策略研究[J].中国数字医学,5(5):17-19.
        </li>
        <li> 	尹爱宁,张汝恩. 2003. 《中医药一体化语言系统》技术标准[J].中国中医药信息杂志,2003,10(7):92-94.
        </li>
        <li> 	李海燕,崔蒙.中医药标准国际化竞争形势分析[J].国际中医中药杂志,2010,32(1):44-45.
        </li>
        <li> 	李海燕, 崔蒙, 任冠华, 谢琪, 范为宇, 尹爱宁. ISO/TC215传统医学信息标准化工作进展 [J]. 国际中医中药杂志, 2011(33)3:193-195.
        </li>
        <li> 	于彤,崔蒙,杨硕. ISO/TC 215传统医学信息标准跟踪研究[J]. 中国数字医学,第8卷,第2期,46-49页,2013.
        </li>
    </ol> 

    <h2><a name="sec-changes" id="sec-changes"></a>9. 变更记录</h2>
    <ul>
        <li>2013-06-10: TCMLS-SN本体规范的最初版本.</li>
    </ul>  
</div>


<?php
include_once ("./foot.php");
?>