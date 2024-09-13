import React, {useEffect, useState} from 'react'
import Home from './Home'

function Data(props) {
    const defaultData={
        name:'not provvided',
        id:'not defiened'
    }
    const {new1 = defaultData    } = props                      
    

    let {name, age, size , aboutMe}= new1

    const [dynamicSize, setDynamicSize] = useState(size)


    useEffect(() => {
      console.log('dynamicSIze', dynamicSize)
      if(dynamicSize > 90){
        alert('Increases the size')
      }

  }, [dynamicSize])

  

    const handleClick=()=>{
      
      setDynamicSize(dynamicSize + 20)
     

    }
  return (
    <div>
       <h1> welcome brro my age {age}</h1>
       <div>
        <span style={{ fontSize: `${dynamicSize}px`}}>
          {age}
        </span>
        </div>
       <button onClick={handleClick}>increase</button>

       {aboutMe.map((data , index) => <div>{index+1}{data}</div>)}
       {age === 'np'?
       <div></div>:
       <div></div>

    }
    </div>
  )
}

export default Data
