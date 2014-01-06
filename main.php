<?php
include_once ("./header.php");
?>
<div class="container">
    <img width ="100%" src ="img/tcmlm_logo.jpg"></img> 
    <div class="container">

        <div class="panel panel-default">
            <div class="panel-heading lead">系统简介</div>
            <div class="panel-body">
                <p>中国中医科学院中医药信息研究所长期致力于中医文献的保护与利用工作，成功研制了大型的结构性文献数据库，
                    并于2012年代表我国向国际标准化组织（ISO）申请了为期两年的“中医文献元数据（简称TCMLM）”标准项目。
                    这是我国中医药信息标准项目在ISO中首次成功立项，具有突破性意义。 为促进该标准的研制、维护和推广工作，拟针对中医文献的特点，研发与TCMLM相互配合的本体和方法，构建TCMLM的示范应用。
                    在本系统中，还实现了一种简单的语义关系发现方法，作为中医文献知识发现的一次尝试。
                </p>
            </div>
        </div>  
        <div class="panel panel-default">
            <div class="panel-heading lead">系统功能</div>
            <div class="panel-body">

                <div class="row" align="center">
                    <div class="col-sm-6 col-md-4">
                        <a  href="index.php" target="_blank">
                            <img src="img/tcmlm-人参.jpg" width="80%" alt="...">
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <a  href="resource_manager.php" target="_blank">
                            <img src="img/tcmlm-input.jpg"  width="80%"  alt="...">
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <a  href="relation_manager.php" target="_blank">
                            <img src="img/脾虚湿热证1.jpg"  width="80%" alt="...">
                        </a>                        
                    </div>

                </div>
                <div class="row"  align="center">

                    <div class="col-sm-6 col-lg-4">
                        <p class="lead"><a href="index.php" target="_blank">文献检索</a></p>      
                        <p> 基于关键词，对中医药文献进行检索（示例：<a href="search.php?keywords=人参&db_name=tcmls"  target="_blank">人参</a>,&nbsp;
                            <a href="search.php?keywords=肾虚证&db_name=tcmls"  target="_blank">肾虚证</a>）。</p>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <p class="lead"><a href="resource_manager.php" target="_blank">文献管理</a></p>
                        <p>对文献进行标注和管理</p>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <p class="lead"><a href="relation_manager.php" target="_blank">文本语义关系发现</a></p>
                        <p>对从文本中发现的语义关系进行检索和浏览（示例：<a href="relation_manager.php?keywords=人参"  target="_blank">人参</a>,&nbsp;
                            <a href="relation_manager.php?keywords=肾虚"  target="_blank">肾虚</a>）。
                        </p>
                    </div>
                </div>      




            </div>
        </div>              
        <div class="panel panel-default">
            <div class="panel-heading lead">文献资源</div>
            <div class="panel-body">
                <p>该系统中已集成了如下的文献资源库：
                </p>
                <?php include_once ("./db_list.php"); ?>
            </div>
        </div>    
        <div class="panel panel-default">
            <div class="panel-heading lead">相关项目</div>
            <div class="panel-body">
                <p class="lead"><a href="project_tcmlm.php">中医药文献元数据标准的示范应用与评价研究</a></p>
                <p>本项目致力于研发中医药文献元数据标准的示范应用，开展该标准的评价研究。 中国中医科学院中医药信息研究所长期致力于中医文献的保护与利用工作，成功研制了64个的结构性文献数据库(方剂数据库,医案数据库)，并于2012年代表我国向国际标准化组织（ISO）申请了为期两年的“中医文献元数据（简称TCM-LM）”标准项目。这是我国中医药信息标准项目在ISO中首次成功立项，具有突破性意义。
                    为促进该标准的研制、维护和推广工作，拟针对中医文献的特点，采用国际先进的本体技术，研发与TCM-LM相互配合的本体和方法，构建TCM-LM的示范应用，对TCM-LM进行系统评价和适当改进。研究内容包括：（1）对TCM-LM与相关元数据标准进行比较分析，阐明TCM-LM的独特性和兼容性；（2）基于描述逻辑，构建符合TCM-LM标准的领域本体，通过机器推理来验证TCM-LM的逻辑严谨性；（3）研发与TCM-LM相配合的语义标注检索方法，验证TCM-LM标准的实用性；（4）基于上述研究结果和专家反馈意见，对TCM-LM标准进行适当改进。
                </p> 
                <hr>
                <p class="lead"><a href="project_relation.php">基于文本的中医药语义关系发现研究</a></p>
                <p>本项目致力于研究基于中医药学语言系统从中医药文献中提取语义关系的方法，为中医药学语言系统的建设提供新颖的技术手段。 中医药学语言系统是中国中医科学院中医药信息研究所于2002年起开始研制的一项大型中医药术语系统，语义网络是语言系统的重要组成部分。为了促进中医药学语言系统的发展，提高系统中语义关系的准确性，本课题拟进行基于文本的中医药语义关系发现研究，以求通过对中医药文献的文本进行分析，并与中医药学语言系统现有语义网络结合，得到准确的语义关系。
                    研究主要内容包括：（1）对目前中医药学语言系统语义网络进行分析，发现问题，并归纳得到基于语义类型层的语义关系网；（2）对中医药文献文本进行分析，发现获得语义关系，并归纳为基于语义类型的语义网络；（3）对文本获得的语义网络与目前的语义关系网进行比较，优化，形成新的语义网络。
                </p>          
            </div>
        </div>    

    </div>
</div> 
<?php
include_once ("./foot.php");
?>
