import React from 'react'
import Data from './Data'
function Home() {
  const data1={
    name:'np',
    age:'☺️',
    size:50,
    aboutMe:[
      "hi",
      "good",
      "thank u"

    ],
  }
  return (
    <div>
      <h1>HI</h1>
      
      <Data new1={data1}/>
    </div>
  )
}


export default Home
