/**
 * SanoBlog 后台设置面板 JS
 * 负责：表单项分组归位、分组切换高亮、折叠展开、返回顶部
 */
(function(){
    function rearrange(){
        var groups=document.querySelectorAll(".sano-config-group");
        if(!groups.length){setTimeout(rearrange,50);return;}
        var bodies=[];
        groups.forEach(function(g){var b=g.querySelector(".sano-config-body");if(b)bodies.push(b);});
        if(!bodies.length)return;

        var container=document.querySelector("form")||document.querySelector(".typecho-body")||document.querySelector(".main-content")||document.body;

        // 收集需要归位的表单项（排除保存按钮，它放独立容器）
        var orphans=[];
        var submitEl=null;
        var children=container.childNodes;
        for(var i=0;i<children.length;i++){
            var el=children[i];
            if(el.nodeType!==1)continue;
            if(el.classList&&(el.classList.contains("sano-config-nav")||el.classList.contains("sano-config-group")||el.classList.contains("sano-config-submit-wrap")||el.classList.contains("sano-back-top")))continue;
            var tag=el.tagName.toLowerCase();
            if(["script","style","link","meta","noscript"].indexOf(tag)!==-1)continue;
            // 识别保存按钮 → 放入独立容器 g-submit
            if(el.querySelector("button[type=\"submit\"]")||(el.classList&&el.classList.contains("typecho-option")&&el.querySelector(".btn.primary"))){
                submitEl=el;
                continue;
            }
            orphans.push(el);
        }

        // 保存按钮 → g-submit（始终可见）
        if(submitEl){
            var sw=document.getElementById("g-submit");
            if(sw)sw.appendChild(submitEl);
        }

        // 按分组顺序分配：基础4→广告5→统计3→侧边栏9→页脚1
        var counts=[4,5,3,9,1];
        var idx=0;
        for(var g=0;g<bodies.length;g++){
            var limit=counts[g]||999;
            for(var c=0;c<limit&&idx<orphans.length;c++,idx++){
                bodies[g].appendChild(orphans[idx]);
            }
        }
        while(idx<orphans.length){
            bodies[bodies.length-1].appendChild(orphans[idx]);idx++;
        }

        // 把分组容器 + 保存按钮容器移入 form 内
        var form=document.querySelector("form");
        if(form){
            var grps=document.querySelectorAll(".sano-config-group");
            for(var i=grps.length-1;i>=0;i--){
                form.insertBefore(grps[i], form.firstChild);
            }
            var sw=document.getElementById("g-submit");
            if(sw)form.appendChild(sw);
        }
    }

    // 切换可见分组（同时高亮导航）
    window.showSection=function(id){
        var all=document.querySelectorAll(".sano-config-group");
        all.forEach(function(g){
            g.style.display=(g.id===id)?"":"none";
        });
        document.querySelectorAll(".sano-config-nav a").forEach(function(a){
            a.classList.toggle("active", a.getAttribute("data-group") === id);
        });
    };

    // 点击分组头折叠/展开 body
    window.toggleBody=function(head){
        var body=head.nextElementSibling;
        if(body&&body.classList.contains("sano-config-body")){
            body.classList.toggle("collapsed");
            var arrow=head.querySelector(".sano-arrow");
            if(arrow){
                arrow.innerHTML=body.classList.contains("collapsed")?"&#9654;":"&#9660;";
            }
        }
    };

    if(document.readyState==="loading"){
        document.addEventListener("DOMContentLoaded",function(){
            rearrange();
            showSection("g-basic");
        });
    }else{
        rearrange();
        showSection("g-basic");
    }
})();
