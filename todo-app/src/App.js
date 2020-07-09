import React, { useState, useEffect } from 'react';
import './App.css';
import { IoMdTrash, IoMdAdd, IoIosArrowUp, IoIosArrowDown } from 'react-icons/io';

function handleErrors(response) {
  if (!response.ok) throw Error(response.statusText);
  return response;
}

function call(url, content) {
  return fetch(url, content).then(handleErrors);
}

function App() {

  const [items, setItems] = useState([]);
  const [newItem, setNewItem] = useState('');

  useEffect(() => {
    call(
      `${process.env.REACT_APP_API_URL}/api/items`,
      {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
      }
    ).then(res => res.json()).then(data => setItems(data))
      .catch(err => alert(err));

  }, []);

  const addItem = () => {
    call(
      `${process.env.REACT_APP_API_URL}/api/item`,
      {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ text: newItem })
      }
    ).then(res => res.json()).then(data => setItems(data))
      .catch(err => alert(err));

    setNewItem('');
  }

  const removeItem = (id) => {
    call(
      `${process.env.REACT_APP_API_URL}/api/item/${id}`,
      {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
      }
    ).then(res => res.json()).then(data => setItems(data))
      .catch(err => alert(err));

  }

  const checkItem = (id, index) => {
    call(
      `${process.env.REACT_APP_API_URL}/api/item/${id}`,
      {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ done: !items[index].done })
      }
    ).then(res => res.json()).then(data => setItems(data))
      .catch(err => alert(err));
  }

  const moveItem = (id, index) => {
    if (index < 0) index = items.length - 1;
    else if (index > items.length - 1) index = 0;

    call(
      `${process.env.REACT_APP_API_URL}/api/item/${id}`,
      {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ index: index })
      }
    ).then(res => res.json()).then(data => setItems(data))
      .catch(err => alert(err));
  }

  return (
    <div className='App'>

      <header className='App-header'>
        <p>To Do - List</p>
      </header>

      <div style={{ width: '25vw', margin: '0 auto' }}>

        <form className='flex space-between' >
          <input type='text' style={{ width: '100%' }} value={newItem} onChange={e => setNewItem(e.target.value)} />
          <button className='flex align-center' onClick={addItem} disabled={newItem === '' ? true : false}><IoMdAdd size={20} /></button>
        </form>

        <ul>
          {
            items.map((item, index) => {
              return <li className='flex align-center' key={item.id}>
                <input type='checkbox' style={{ marginRight: '15px' }} checked={item.done} onChange={() => checkItem(item.id, index)} />
                <div>{item.text}</div>
                <div className='arrows'>
                  <IoIosArrowUp className='arrow' style={{ marginBottom: '-3px' }} onClick={() => moveItem(item.id, item.index - 1)} />
                  <IoIosArrowDown className='arrow' style={{ marginTop: '-3px' }} onClick={() => moveItem(item.id, item.index + 1)} />
                </div>
                <IoMdTrash size={20} style={{ marginLeft: '10px', color: '#FF5555', cursor: 'pointer' }} onClick={() => removeItem(item.id)} />
              </li>
            })
          }
        </ul>

      </div>

    </div >
  );
}

export default App;
