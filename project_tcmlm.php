<?php
include_once ("./header.php");
?>
<div class="container">
    <img width ="100%" src ="img/tcmlm_project.jpg"></img>
    <div class="container">
        <p class="lead"><strong>项目介绍</strong></p>        
        <p>中国中医科学院中医药信息研究所长期致力于中医文献的保护与利用工作，成功研制了大型的结构性文献数据库，并于2012年代表我国向国际标准化组织（ISO）申请了为期两年的“中医文献元数据（简称TCM-LM）”标准项目。
            这是我国中医药信息标准项目在ISO中首次成功立项，具有突破性意义。为促进该标准的研制、维护和推广工作，拟针对中医文献的特点，在分析“都柏林核心”等元数据标准的基础上，
            采用国际先进的本体和语义Web技术，研发与TCM-LM相互配合的本体和方法，构建TCM-LM的示范应用，对TCM-LM进行系统评价和适当改进。</p>
        <p>    
            研究内容包括：（1）对TCM-LM与相关元数据标准进行比较分析，阐明TCM-LM的独特性和兼容性；（2）基于描述逻辑，构建符合TCM-LM标准的领域本体，通过机器推理来验证TCM-LM的逻辑严谨性；（3）研发与TCM-LM相配合的语义标注、索引和检索方法，构建示范性的文献知识库和检索系统，验证TCM-LM标准的实用性；（4）基于上述研究结果和专家反馈意见，对TCM-LM标准进行适当改进。
        </p>
        <hr>    
        <p class="lead"><strong>从万方知识服务平台获取文献资源</strong></p> 
        <p>我们以TCMLS中的词汇作为关键词，从“万方数据知识服务平台”中检出了217667万篇文献题录，存入一个MySQL数据库中，构成“中医药文献库”。在“中医药文献库”的基础上，实现了<a href="index.php?db=tcmls">基于Web的文献检索系统</a>，支持基于关键词的文献检索功能。这样一个从万方数据知识服务平台中获取的中医药文献库，可以支持文本关系发现，文献标引等文本挖掘实验和文献检索应用，为后续工作奠定了基础。
        <p class="lead"><strong>基于Web的文献检索系统</strong></p> 


        <p align="center">
            <a href="search.php?db_name=tcmls&keywords=四君子汤">
                <img width ="80%" src ="img/tcmlm_search.jpg"></img>
            </a>              
        </p>   
        下面举一些例子：
        <div class="row" align="center">
            <div class="col-sm-6 col-md-4">                
                <a href="search.php?db_name=tcmls&keywords=四君子汤">
                    <img width="80%" src ="img/四君子汤.jpg" alt="...">
                </a>
            </div>

            <div class="col-sm-6 col-md-4">                
                <a href="search.php?db_name=tcmls&keywords=柴胡桂枝干姜汤">
                    <img width="60%" src ="img/柴胡桂枝干姜汤.jpg" alt="...">
                </a>
            </div>
            <div class="col-sm-6 col-md-4">    
                <a href="search.php?db_name=tcmls&keywords=补气养血汤">
                    <img width="55%" src ="img/补气养血汤.jpg" alt="...">       
                </a>                               
            </div>
        </div>
        <div class="row" align="center">
            <div class="col-sm-6 col-md-4">    
                <p class="lead"><a href="search.php?db_name=tcmls&keywords=四君子汤">四君子汤</a></p>
                <p>同名方约有7首，现选《太平惠民和剂局方》治一切气方。组成：人参（去芦）、甘草（炙）、 茯苓（去皮）、白术各等分。</p>                     
            </div>
            <div class="col-sm-6 col-md-4">    
                <p class="lead"><a href="search.php?db_name=tcmls&keywords=柴胡桂枝干姜汤">柴胡桂枝干姜汤</a></p>
                <p> 处方来源为《伤寒论》。药物组成:	柴胡半斤，桂枝3两（去皮），干姜2两，栝楼根4两，黄芩3两，牡蛎2两（熬），甘草2两（炙）。</p>                     
            </div>
            
           
            
            <div class="col-sm-6 col-md-4"> 
                <p class="lead"><a href="search.php?db_name=tcmls&keywords=补气养血汤">补气养血汤</a></p>
                <p>《中医原著选读》引关幼波方（见《古今名方》）。药物组成:	生黄耆15g，首乌15g，白芍15g，川续断15g，当归12g，丹参12g，黄精12g，生地12g，五味子12g，生甘草9g。</p>                    
            </div>
            <div class="col-sm-6 col-md-4">        
            </div>
        </div>
    </div>



    <p align="center">
        <a class="btn btn-lg btn-success" href="ontologies/spleen-1.0.owl" role="button"><span class="glyphicon glyphicon-download"></span>&nbsp;下载本体</a>
        <a class="btn btn-lg btn-primary" href="docs/spleen.docx" role="button"><span class="glyphicon glyphicon-download"></span>&nbsp;下载技术报告</a>
    </p>

    <hr>
</div> <!-- /container -->

<?php
include_once ("./foot.php");
?>