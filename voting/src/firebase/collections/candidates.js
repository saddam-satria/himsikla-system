import { collection } from 'firebase/firestore';
import { firestore } from '../../config/firebase';

const CandidateCollection = collection(firestore, 'candidate');

export default CandidateCollection;
