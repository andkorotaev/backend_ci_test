Vue.component('comment-component', {
	template: '#comment-component',
	props: ['comments', 'padding'],
	methods: {
		scrollToElement(value) {
			this.$parent.scrollToElement(value);
		},
		addLike(value1, value2) {
			this.$parent.addLike(value1, value2);
		},
		toComment(value) {
			this.$parent.toComment(value);
		}
	}
})

var app = new Vue({
	el: '#app',
	data: {
		currentBalance: 0,
		currentLikes: 0,
		balanceModalTransactions: null,
		balanceModalInfo: null,
		likesModalInfo: null,
		login: '',
		pass: '',
		post: false,
		invalidLogin: false,
		invalidPass: false,
		invalidSum: false,
		posts: [],
		addSum: 0,
		amount: 0,
		likes: 0,
		commentText: '',
		commentTo: null,
		packs: [
			{
				id: 1,
				price: 5
			},
			{
				id: 2,
				price: 20
			},
			{
				id: 3,
				price: 50
			},
		],
	},
	computed: {
		test: function () {
			var data = [];
			return data;
		}
	},
	created(){
		var self = this
		axios
			.get('/main_page/get_all_posts')
			.then(function (response) {
				self.posts = response.data.posts;
			})

		this.updateBalance();
	},
	methods: {
		openBalanceModal: function() {
			var self= this;
			axios.get('/main_page/get_balance_info')
				.then(function (response) {
					self.balanceModalTransactions = response.data.balance;
					self.balanceModalInfo = response.data.user;

					let element = self.$el.getElementsByClassName('balance-modal')[0];
					$(element).modal('show');

				})
		},
		openLikesModal: function() {
			var self= this;
			axios.get('/main_page/get_likes_info')
				.then(function (response) {
					self.likesModalInfo = response.data.info;

					let element = self.$el.getElementsByClassName('likes-modal')[0];
					$(element).modal('show');
				})
		},
		updateBalance: function() {
			var self= this;
			axios.get('/main_page/get_balance')
				.then(function (response) {
					self.currentBalance = response.data.balance;
					self.currentLikes = response.data.likes;
				})
		},
		logout: function () {
			console.log ('logout');
		},
		logIn: function () {
			var self= this;
			if(self.login === ''){
				self.invalidLogin = true
			}
			else if(self.pass === ''){
				self.invalidLogin = false
				self.invalidPass = true
			}
			else{
				self.invalidLogin = false
				self.invalidPass = false

				var formdata = new FormData();
				formdata.append("login", self.login);
				formdata.append("password", self.pass);

				axios.post('/main_page/login', formdata)
					.then(function (response) {
						window.location.reload(false);
						/*setTimeout(function () {
							$('#loginModal').modal('hide');
						}, 500);*/
					})
			}
		},
		fiilIn: function () {
			var self= this;
			if(self.addSum === 0){
				self.invalidSum = true
			}
			else{
				self.invalidSum = false

				var formdata = new FormData();
				formdata.append("sum", self.addSum);

				axios.post('/main_page/add_money', formdata)
					.then(function (response) {
						self.updateBalance();
						setTimeout(function () {
							$('#addModal').modal('hide');
						}, 500);
					})
			}
		},
		openPost: function (id) {
			var self= this;
			axios
				.get('/main_page/get_post/' + id)
				.then(function (response) {
					self.post = response.data.post;
					if(self.post){
						setTimeout(function () {
							$('#postModal').modal('show');
						}, 500);
					}
				})
		},
		addLike: function (assign_id, type) {
			var self= this;

			var formdata = new FormData();
			formdata.append("assign_id", assign_id);
			formdata.append("type", type);

			axios
				.post('/main_page/like', formdata)
				.then(function (response) {
					self.updateBalance();

					let type = response.data.type;

					if (type === 'post') {
						self.post.likes = response.data.likes;
					} else if (type === 'comment') {
						let index = self.post.coments.findIndex((item) => item.id === response.data.assign_id);
						self.post.coments[index].likes = response.data.likes;
					}
				})

		},
		buyPack: function (id) {
			var self= this;
			axios.post('/main_page/buy_boosterpack/' + id)
				.then(function (response) {
					self.updateBalance();
					self.amount = response.data.amount
					if(self.amount !== 0){
						setTimeout(function () {
							$('#amountModal').modal('show');
						}, 500);
					}
				})
		},

		scrollToElement: function (className) {
			const el = this.$el.getElementsByClassName(className)[0];

			if (el) {
				el.scrollIntoView();
				el.style.background = "#f6baba";
				setTimeout(function () {
					el.style.background = "#FFF";
				}, 500);
			}
		},

		addComment: function () {
			var self= this;
			var formdata = new FormData();
			formdata.append("post_id", self.post.id);
			formdata.append("message", self.commentText);
			formdata.append("reply_id", self.commentTo);

			axios.post('/main_page/comment', formdata)
				.then(function (response) {
					self.post = response.data.post;

					self.commentText = '';
					self.commentTo = null;
				})
		},

		toComment: function (id) {
			var self= this;
			const el = this.$el.getElementsByClassName('new-comment-form')[0];
			self.commentTo = id;

			if (el) {
				el.scrollIntoView();
			}


		}
	}
});

