<div id="guru-widget" style="position:fixed;bottom:24px;left:24px;z-index:9999;font-family:var(--font-sans)">
    <button id="guru-toggle" onclick="toggleGuru()" style="width:56px;height:56px;border-radius:50%;border:none;cursor:pointer;background:linear-gradient(135deg,#C0392B,#96281B);box-shadow:0 4px 20px rgba(192,57,43,0.4);display:flex;align-items:center;justify-content:center;font-size:24px;color:white;" title="Chat with Guru AI">🧿</button>
    <div id="guru-window" style="display:none;position:absolute;bottom:70px;left:0;width:340px;height:480px;background:rgba(255,255,255,0.97);backdrop-filter:blur(20px);border-radius:20px;border:1px solid rgba(0,0,0,0.08);box-shadow:0 20px 60px rgba(0,0,0,0.15);flex-direction:column;overflow:hidden;">
        <div style="background:linear-gradient(135deg,#C0392B,#96281B);padding:16px;display:flex;align-items:center;gap:10px;">
            <div style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:20px;">🧿</div>
            <div>
                <div style="color:white;font-weight:700;font-size:15px;">Guru</div>
                <div style="color:rgba(255,255,255,0.7);font-size:11px;">Nepal News AI Assistant</div>
            </div>
            <button onclick="toggleGuru()" style="margin-left:auto;background:rgba(255,255,255,0.15);border:none;color:white;width:28px;height:28px;border-radius:50%;cursor:pointer;font-size:18px;line-height:1;">×</button>
        </div>
        <div id="guru-messages" style="flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;"></div>
        <div id="guru-quick" style="padding:0 12px 8px;display:flex;gap:6px;flex-wrap:wrap;">
            <button class="guru-quick-btn" onclick="quickAsk('Summarise the current article for me')">Summarise</button>
            <button class="guru-quick-btn" onclick="quickAsk('Translate hello to Nepali')">🌐 Translate</button>
            <button class="guru-quick-btn" onclick="quickAsk('What is happening in Nepal?')">🇳🇵 Nepal news</button>
        </div>
        <div style="padding:12px;border-top:1px solid rgba(0,0,0,0.06);display:flex;gap:8px;">
            <input id="guru-input" type="text" placeholder="Ask Guru anything..." maxlength="500" onkeydown="if(event.key==='Enter')sendToGuru()" style="flex:1;border:1.5px solid rgba(0,0,0,0.1);border-radius:22px;padding:9px 14px;font-size:13px;outline:none;font-family:inherit;" onfocus="this.style.borderColor='#C0392B'" onblur="this.style.borderColor='rgba(0,0,0,0.1)'"/>
            <button onclick="sendToGuru()" style="background:linear-gradient(135deg,#C0392B,#96281B);border:none;border-radius:50%;width:38px;height:38px;color:white;cursor:pointer;font-size:16px;flex-shrink:0;">➤</button>
        </div>
    </div>
</div>
<style>
.guru-msg{max-width:85%;padding:10px 14px;border-radius:16px;font-size:13px;line-height:1.55;}
.guru-bot{background:rgba(192,57,43,0.06);border:1px solid rgba(192,57,43,0.1);color:#1d1d1f;border-radius:4px 16px 16px 16px;align-self:flex-start;}
.guru-user{background:linear-gradient(135deg,#C0392B,#96281B);color:white;border-radius:16px 4px 16px 16px;align-self:flex-end;}
.guru-typing{display:flex;gap:4px;padding:12px 14px;background:rgba(192,57,43,0.06);border:1px solid rgba(192,57,43,0.1);border-radius:4px 16px 16px 16px;align-self:flex-start;}
.guru-typing span{width:6px;height:6px;border-radius:50%;background:#C0392B;opacity:0.4;animation:guruDot 1.2s infinite;}
.guru-typing span:nth-child(2){animation-delay:0.2s}
.guru-typing span:nth-child(3){animation-delay:0.4s}
@keyframes guruDot{0%,60%,100%{opacity:0.4;transform:translateY(0)}30%{opacity:1;transform:translateY(-4px)}}
.guru-quick-btn{font-size:11px;padding:5px 10px;border-radius:20px;border:1.5px solid rgba(192,57,43,0.2);background:rgba(192,57,43,0.05);color:#C0392B;cursor:pointer;font-family:inherit;}
#guru-messages::-webkit-scrollbar{width:4px}
#guru-messages::-webkit-scrollbar-thumb{background:rgba(192,57,43,0.2);border-radius:2px}
</style>
<script>
let guruOpen=false;
function toggleGuru(){
    guruOpen=!guruOpen;
    const w=document.getElementById('guru-window');
    w.style.display=guruOpen?'flex':'none';
    if(guruOpen){
        if(document.getElementById('guru-messages').children.length===0){
            addMsg('नमस्ते! I\'m Guru 🙏 Your AI assistant for Nepal News Australia.<br><br>Ask me to <b>summarise an article</b>, <b>translate</b> something, or anything about <b>Nepal & Australia</b>!','bot');
        }
        document.getElementById('guru-input').focus();
    }
}
function quickAsk(msg){document.getElementById('guru-input').value=msg;sendToGuru();}
function addMsg(text,type){
    const msgs=document.getElementById('guru-messages');
    const div=document.createElement('div');
    div.className='guru-msg guru-'+type;
    div.innerHTML=text;
    msgs.appendChild(div);
    msgs.scrollTop=msgs.scrollHeight;
    return div;
}
function addTyping(){
    const msgs=document.getElementById('guru-messages');
    const div=document.createElement('div');
    div.className='guru-typing';
    div.id='guru-typing-indicator';
    div.innerHTML='<span></span><span></span><span></span>';
    msgs.appendChild(div);
    msgs.scrollTop=msgs.scrollHeight;
}
function removeTyping(){const t=document.getElementById('guru-typing-indicator');if(t)t.remove();}
function getPageContext(){
    const title=document.querySelector('.article-title,h1');
    const summary=document.querySelector('.article-summary,.article-content p');
    if(title)return(title.innerText||'')+'.'+(summary?summary.innerText.slice(0,300):'');
    return'';
}
async function sendToGuru(){
    const input=document.getElementById('guru-input');
    const msg=input.value.trim();
    if(!msg)return;
    input.value='';
    addMsg(msg,'user');
    document.getElementById('guru-quick').style.display='none';
    addTyping();
    try{
        const res=await fetch('{{ route("guru.chat") }}',{
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
            body:JSON.stringify({message:msg,context:getPageContext()})
        });
        const data=await res.json();
        removeTyping();
        addMsg(data.reply,'bot');
    }catch(e){
        removeTyping();
        addMsg('Sorry, Guru is unavailable right now. Please try again! 🙏','bot');
    }
}
</script>
