import { collection } from 'firebase/firestore';
import { firestore } from '../../config/firebase';

const VoterCollection = collection(firestore, 'voter');

export default VoterCollection;
