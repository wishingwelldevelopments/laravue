<template>
	<div>
		<input type="text" placeholder="Last Name :" v-model="query" @keypress.enter="fetchMeth" autofocus/>
		<div class="holder" v-if="narray.length > 0">
			<p v-for="(n, i) in narray" :key="i">
				{{ n['Given names'] }} {{ n['Last name'] }} went to {{ n['Court sitting location'] }} prison
			</p>
			<a href="#" v-if="isqueried=true" id="save" @click.prevent="foo()">Save Search Results</a>
		</div>
		<p v-else>Please Enter a Valid Search Term</p>
	</div>
</template>

<script>
export default {
	name:'app',
	data() {
		return{
			narray: [],
			query:'',
			isqueried:false,
			api_base:'http://www.data.qld.gov.au/api/3/action/datastore_search?resource_id=96c31de0-78da-4754-8793-750e370a3fdc&'
		}
	},
	methods:{
		fetchMeth (){
			this.narray=[];
			console.log('fetching');
			fetch(`${this.api_base}q={"Last name":"${this.query}"}`)
				.then(res => {
					return res.json();
				}).then(this.setRes);
		},
		setRes(results){
			this.narray = results.result.records;
			this.isqueried = true;
			if(this.query == "black"){
				this.narray.push({ "_id": 19113, "Last name": "BLACK", "Given names": "Sirius", "Court sitting location": "Azkaban"});
			}
		},
		foo(){
			axios.post('addPrisoner', {
				'ArrayData':this.narray
			}).then((res)=>{
				console.log(res);
			}).catch(function(error){
				console.log(error);
			});
		}
	}
}
</script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
*{
	margin:0px;
	padding:0px;
	border:0px;
	outline:none;
	font-family: 'Poppins', sans-serif;
}
input{
	width:100%;
	padding:10px;
	box-sizing:border-box;
	background-color:whitesmoke;
	}
input::placeholder{
	color:#616161;
}
p{
	width:100%;
	padding:10px;
	color:#9c9c9c;
	box-sizing:border-box;
	border-top:1px solid grey;
}
#save{
	width:100%;
	padding:10px;
	box-sizing:border-box;
	color: #2f2f2f;
	background-color: #0d0d0d40;
	display:block;
	text-decoration:none;
}
</style>
