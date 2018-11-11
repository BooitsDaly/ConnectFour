const express = require('express')
const path = require('path')
const cookieParser = require('cookie-parser')
const bodyParser = require('body-parser')
const handlebars = require('express-handlebars')
const validator = require('express-validator')
const flash = require('connect-flash')
const session = require('express-session')
const passport = require('passport')
const passLocal = require('passport-local').Strategy
const mongo = require('mongodb')
const mongoose = require('mongoose')
mongoose.connect('mongodb://admin:STARwars33!!@ds255403.mlab.com:55403/connectfourdb',{useNewUrlParser: true})
const db = mongoose.connection

const routes = require('./routes/index')
const users = require('./routes/users')

//init app
const app = express()

//view engine
app.set('views', path.join(__dirname,'views'))
app.engine('handlebars', handlebars({defaultLayout: 'layout'}))
app.set('view engine', 'handlebars')

//body parser middleware
app.use(bodyParser.json())
app.use(bodyParser.urlencoded({extended: false}))
app.use(cookieParser())

//set static folder
app.use(express.static(path.join(__dirname, '/public')))

//express Session
app.use(session({secret: 'secret', saveUninitialized: true, resave: true}))

// Passport init
app.use(passport.initialize())
app.use(passport.session())

// Express Validator
app.use(validator({
    errorFormatter: function(param, msg, value) {
        var namespace = param.split('.')
        , root    = namespace.shift()
        , formParam = root
  
      while(namespace.length) {
        formParam += '[' + namespace.shift() + ']'
      }
      return {
        param : formParam,
        msg   : msg,
        value : value
      }
    }
  }))

  //connect flash
  app.use(flash())

  // Global Vars
app.use(function (req, res, next) {
    res.locals.success_msg = req.flash('success_msg')
    res.locals.error_msg = req.flash('error_msg')
    res.locals.error = req.flash('error')
    res.locals.user = req.user || null
    next()
  })

app.use('/', routes)
app.use('/users', users)

// Set Port
app.set('port', (process.env.PORT || 3000))

app.listen(app.get('port'), function(){
	console.log('Server started on port '+app.get('port'))
});

