<template>
    <div>
        <main id="app">
            <div class="row align-items-center">
                <div class="col-sm-2">
                    <div class="row w-100 align-items-center flex-nowrap">
                        <div class="logo">
                            <img :src="logoURL" alt="" srcset="">
                        </div>
                        <span class="text-white w-100 pl-2">
                            Insight Ai
                        </span>
                    </div>
                </div>
                <div class="col-sm-10">
                    <header>               
                        <nav>                    
                            <ul>
                                <li v-for="(tab, tabName) in tabs" :key="tabName">
                                    <button 
                                        class="tab" 
                                        @click="setTabActive($event,tabName)"
                                        :class="{'active': tabName === activeTab}"
                                    >
                                        <span class="tab-copy">{{ tabName }}</span>
                                            <span class="tab-background">
                                            <!-- <span class="tab-rounding left"></span>
                                            <span class="tab-rounding right"></span> -->
                                        </span>
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </header>
                </div>
            </div>
            
            <article>
                
                <div class="container">    
                       
                <transition
                    name="fade"
                    mode="out-in"
                    appear
                    :duration="500" > 

                    <tab-content
                            v-for="(tabContent, t) in tabs" 
                            :data="tabContent"
                            :key="'content'+t"
                            :api_key="chatGptApi"
                            v-if="t === activeTab"
                            inline-template
                        >
                        
                        <div class="tab_content">
                            <div v-if="data.slug == 'setting'" >
                                <h1>{{ data.title }}</h1>

                                <div  class="p-4">
                                    <div class="form-group">
                                        <label for="api">Chat GPT API</label>                                
                                        <input type="password" 
                                            class="form-control w-50" 
                                            :value="api_key"
                                            name="insight-ai-settings[chat-gpt][key]" 
                                            id="api" 
                                            aria-describedby="chatgpt_help" 
                                            placeholder=""
                                        >
                                        <small id="chatgpt_help" class="form-text text-muted">
                                            If you need to chat with Chat GPT you need to add API of ChatGPT
                                        </small>
                                    </div>

                                    <button type="submit" class="btn ">Save</button>
                                </div>

                            </div>

                            <div v-if="data.slug == 'help'" >
                                <h1>{{ data.title }}</h1>
                                <div class="p-4">
                                    <ul >
                                        <li>
                                            <h4>Insight AI</h4>
                                            <span class="pl-4 pt-2 d-block">Using Insight AI to apply chat GPT on your site</span>
                                            <span class="pl-4  pt-2 d-block">You can use this shortcode to display Chat : <strong>[insight-ai-chat-gpt]</strong></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </tab-content>   
                </transition>
                </div>
            </article>
        </main>

    </div>
</template>

<script> 

export default {
    data() {
        return {
            logoURL: '',
            chatGptApi: '',
            message: 'Hello',
            tabs: {
                'Settings': {
                    title: 'Settings',
                    slug: 'setting'
                },
                'Help': {
                    title: 'Help',
                    slug: 'help'
                },            
            },
            activeTab: 'Settings',
        }
    },
    mounted() {
        this.logoURL = window.ajaxData.InsightAiPluginURL + 'assets/images/insight-logo.png';  
        this.chatGptApi = window.ajaxData.api_key;
    },
    computed:{
        tabContent() {
            return this.tabs[this.activeTab];
        },
    },
    methods: {
        setTabActive($event,tab) {
            $event.preventDefault();
            this.activeTab = tab; 
        },
    },
    components:{
        'TabContent': {
            props: {
                data: Object,
                api_key:String
            },
        }
    },
}
</script>
