<template>
	<div class="AI_chat_box">
		<vue-advanced-chat			
			show-search=false
			show-add-room=false
			show-files=false
			show-audio=false
			rooms-list-opened=false
			show-emojis=false
			show-reaction-emojis=false
			emojis-suggestion-enabled=false
			single-room=true
			:current-user-id="currentUserId"
			:rooms="JSON.stringify(rooms)"
			:rooms-loaded=false
			:messages-loaded=true
			:messages="JSON.stringify(messages)"
			text-formatting='{"italic": "null"}'
			@send-message="sendMessage($event.detail[0])"
			@fetch-messages="fetchMessages($event.detail[0])"
		/>
		<div class="overlay" :id="isActive">
			<div class="spinner-grow text-success" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
	</div>
	
</template>
  
<script>

	import axios from 'axios'
	import { register } from 'vue-advanced-chat'
	register()

	export default {
		components: {

		},
		data() {
			return {
				currentUserId: '1234',
				rooms: [
					{
						roomId: '1',
						roomName: 'Chat GPT',
						avatar: this.logoURL,
						users: [
							{ _id: '1234', username: 'John Doe' },
							{ _id: '4321', username: 'Chat GPT' }
						]
					}
				],
				logoURL:"",
				messages: [],
				http: "",
				chatGptApi:"",
				overlay:"none",
				isActive: ""
			}
		},
		beforeMount() {
			this.init()
		},
		methods: {
			init: function() { 
				this.chatGptApi = window.ajaxData.api_key;
				// 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
				this.http = axios.create({
					baseURL: 'https://api.openai.com/v1/chat',
					headers: {
						'Content-Type': 'application/json',
						Authorization: 'Bearer ' + this.chatGptApi,
						'OpenAI-Organization': 'org-IznwRKZe0QQUe6avETEybdNj',
					}
				});
				this.logoURL = window.ajaxData.InsightAiPluginURL + 'assets/images/insight-logo.png';  
				this.rooms[0].avatar = window.ajaxData.InsightAiPluginURL + 'assets/images/insight-logo.png';  
			},

			fetchMessages({ room, options }) {
				this.messagesLoaded = false
				setTimeout(() => {
					this.messages = []
					this.messages.push({
						_id: '123',
						content: 'Hello! How Can i Help You',
						senderId: '4321',
						username: 'Chat GPT',
						date: new Date().toDateString(),
						timestamp: new Date().toString().substring(16, 21)
					});
					this.messagesLoaded = true
				})
			},
			addMessages(reset) {
				const messages = []
				messages.push({
					_id: '123',
					content: 'Hello! How Can i Help You',
					senderId: '4321',
					username: 'Chat GPT',
					date: new Date().toDateString(),
					timestamp: new Date().toString().substring(16, 21)
				})
				return messages
			},
			sendMessage(message) {				
				this.messages = [
					...this.messages,
					{
						_id: this.messages.length,
						content: message.content,
						senderId: this.currentUserId,
						timestamp: new Date().toString().substring(16, 21),
						date: new Date().toDateString()
					}
				];
				var functions = this;
				this.isActive = "active";
				this.http.post('/completions', {
					"model": "gpt-3.5-turbo",
					"messages": [{"role": "user", "content": message.content}],
					"temperature": 0.7
				}).then(function (response) {
					// console.log(response.data.choices[0].message.content)
					functions.addNewMessage(response.data.choices[0].message.content.replaceAll("```","\n"));
				}).catch(function (error) {
					// console.log(error.response.data.error.message);
					functions.addNewMessage(error.response.data.error.message.replaceAll("```","\n"));
				}).finally(() => {
					// btnText.value = BTN_TEXT
					this.isActive = "";
				})
			},
			addNewMessage(text) {
				this.messages = [
					...this.messages,
					{
						_id: this.messages.length,
						content: text,
						senderId: '4321',
						timestamp: new Date().toString().substring(16, 21),
						date: new Date().toDateString()
					}
				]
			}
		}
	}
</script>