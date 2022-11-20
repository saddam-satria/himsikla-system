import { initializeApp } from 'firebase/app';
import { getFirestore } from 'firebase/firestore';
import { FIREABASE_CONFIG } from './constant';

const firebase = initializeApp(FIREABASE_CONFIG);
const firestore = getFirestore(firebase);

export { firebase, firestore };
