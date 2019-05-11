<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="favicon.ico"/>
    <title> REACT EXAMPLE </title>

    <meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />


<script src="js/react.production.min.js"></script>
<script src="js/react-dom.production.min.js"></script>
<script src="js/babel.min.js"></script>
<script src="js/axios.min.js"></script>
<script src="js/react-router-dom.min.js"></script>


</head>




<body>


<!-------------------------HTML DIV------------------------------->

<header id="root">

</header>


<section id="sectionroot">

</section>


<section id="form">

</section>




<!----------------------------------SCRIPT TAGS--------------------------->

<script type="text/babel">


const BrowserRouter = ReactRouterDOM.BrowserRouter
const HashRouter = ReactRouterDOM.HashRouter
const Route = ReactRouterDOM.Route
const NavLink = ReactRouterDOM.NavLink
const Switch = ReactRouterDOM.Switch

class Header extends React.Component
{
   render()
   {
       return(
           <div>
           <div className="headerleft col-sm-12 col-xs-12">
 <HashRouter> 
     <NavLink to="/">
        <img src="http://localhost/reactexample/favicon.jpg" className="headerimg" />
        </NavLink>
        </HashRouter>
          </div>
          </div>
       );
   }
}


ReactDOM.render(
  <Header />,
  document.getElementById("root")
);







/****
 * LOAD SEARCH RESULTS AS USER TYPES
 * | This class loads results from db as
 * |  user types like facebook search
 * |
 */

class Searchloader extends React.Component
{
   constructor(props)
   {
     super(props);
     this.state = {search : '', isLoaded : true, error : null, contents : []};
   }

   handleChange(event)
   {
     const valuex = event.target.value;

     this.setState({search : valuex, isLoaded : false});

     const API_PATH2 = "http://localhost/reactexample/search.php?msg="+this.state.search;


     fetch(`${API_PATH2}`)
       .then(result => result.json())//sets our result to json format
       .then(
         (result) => {
           this.setState({
             isLoaded: true,
             error : null,
             contents : result.contents
           });
         },
        // Note: it's important to handle errors here
         // instead of a catch() block so that we don't swallow
         // exceptions from actual bugs in components.
         (error) => {
           this.setState({
             isLoaded: true,
              error : 'No Results Found'
           });
         }
       )
     event.preventDefault();
        }
   
   render()
   {
      const { error, isLoaded, contents, search, isClicked} = this.state;

      let srccontent;
      let btncontent;

      if (error)
     {
     srccontent =  <div className="errorm">{this.state.error}</div>;
    } 
    else if (!isLoaded) 
    {
     srccontent = <div className="loader"></div>;
    }
    else if((!error) && (isLoaded) && (search != ""))
    {
      srccontent = 
        <ul className="lists">
        {contents.map(content => (

          /** In the NavLink, we pass :
           * 1) The path through PATHNAME, this calls forth <Route path='/profile' />
           * 2) A state IDNUMBER which will serve as props on another component (PROFILE)
           */

          <NavLink to={{pathname : '/profile', state: {idnumber: content.id}}} key={content.id}>
            <li>
            <div className="imglists">
            <img src={"http://localhost/reactexample/profilepics/"+content.photos} className="img"/> 
            </div>
            {content.firstname} {content.lastname}
            </li>
          </NavLink>
                      ))}
   </ul>;
    }   
    
  btncontent = 
    <div>
<div className="form-group contentround">

           <div className="form-group contentload">

     <div className="form-group writex">

    <input name="search" value={this.state.search} className="form-group" onChange={(e) => this.handleChange(e)} placeholder="Search keyword" />

      </div> 

      <div>
      {srccontent}
      </div>
   
     </div>

     </div>
         </div>

     return(
       <div>
      {btncontent}
      </div>

     );
   }
}



class Profile extends React.Component
{
  constructor(props)
  {
    super(props);
    this.state = {error : null, isLoaded : false, items : []};
  }

  componentDidMount()
  {
    const {handle} = this.props.match.params;
    const { idnumber } = this.props.location.state;

    //The CONST {handle} helps in notifying of state props passed from another component (SEARCHLOADER)
    //The CONST {idnumber} gets the state that was passed from another component (SEARCHLOADER)

     fetch(`http://localhost/reactexample/answers.php?msg=${idnumber}`)
       .then(result => result.json())//sets our result to json format
       .then(
         (result) => {
           this.setState({
             isLoaded: true,
             error : null,
             items : result.items
           });
         },
        // Note: it's important to handle errors here
         // instead of a catch() block so that we don't swallow
         // exceptions from actual bugs in components.
         (error) => {
           this.setState({
             isLoaded: true,
              error : 'No Results Found'
           });
         }
       )
     event.preventDefault();
  }

  componentWillUnmount()
  {
         this.setState({
             isLoaded: false,
             error : null,
             items : []
           });
  }

  render()
  {
    const { error, isLoaded, items} = this.state;

    if (error)
     {
     return  <div className="errorm">{this.state.error}</div>;
    } 
    else if (!isLoaded) 
    {
     
    }
    return(
  <div className="form-group resultprf">

        {/*** GET RESULTS FROM DATABASE */}

          {items.map(item => (
<div key={item.id}>

<div className="imgsrc">
<img src={"http://localhost/reactexample/profilepics/"+item.photos} className="img"/>
</div>

<div className="nameprf">
<h3> {item.firstname} {item.lastname} </h3>
</div>

<div className="profile-lists">
<li>
<span className="fa fa-home"></span> Lives in : {item.state}, {item.nation}
</li>
<li>
<span className="fa fa-map-marker"></span> Address : {item.address}
</li>
<li>
<span className="fa fa-phone"></span> Phone Number : {item.mobile}
</li>
<li>
<span className="fa fa-envelope-o"></span> Email Address : {item.email}
</li>
</div>

</div>

          ))}
      </div>
    );
  }
}






class Router extends React.Component {
    constructor(props)
     {
        super(props);
    }

    render() {
        return (
               <HashRouter> 
                <Switch>
                    <Route path='/profile' component={ Profile } />
                 <Route exact path='/' component={ Searchloader } /> 
                </Switch>
                </HashRouter>
        );
    }
};

//the Component in the 'exact path' Route is the one to be displayed on Page load.
//On Page load, display SEARCHLOADER component

const rootEl = document.getElementById('sectionroot');

ReactDOM.render(
    <Router />,
    rootEl
);


</script>







</body>



</html>
