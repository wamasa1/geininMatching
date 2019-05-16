new Vue ({
  el: '#app',
  methods: {
    handleClick: function () {
      window.confirm('メッセージを送信してよろしいですか？')
    }
  }
})
