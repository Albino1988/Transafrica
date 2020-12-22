import React from 'react'
import Modal from 'react-modal'
import ModalEnvatoIcon from './ModalEnvatoIcon'
import styles from './MagicModalWrapper.module.scss'
const customStyles = {
  overlay: {
    backgroundColor: 'rgba(32, 32, 32, 0.81)',
    zIndex: 199999
  },
  content: {
    background: '#f1f1f1',
    border: '0',
    top: '50%',
    left: '50%',
    right: 'auto',
    bottom: 'auto',
    marginRight: '-50%',
    padding: '0',
    transform: 'translate(-50%, -50%)',
    borderRadius: '4px'
  }
}

const MagicModalWrapper = ({ photoId, photoTitle, onCloseCallback = null, children }) => {
  const [modalIsOpen, setModalIsOpen] = React.useState(true)
  const closeModal = () => {
    setModalIsOpen(false)
    if (onCloseCallback) {
      onCloseCallback()
    }
  }

  // Make sure to bind modal to your appElement (http://reactcommunity.org/react-modal/accessibility/)
  // We get window.envatoElements.modalAppHolder from our initial render in main.jsx:
  if (typeof window !== 'undefined' && window.envatoElements && window.envatoElements.modalAppHolder) {
    Modal.setAppElement(window.envatoElements.modalAppHolder)
  }

  return (
    <Modal
      isOpen={modalIsOpen}
      onRequestClose={closeModal}
      style={customStyles}
      contentLabel='Envato Elements'
      data-testid='modal-wrapper'
    >
      <div className={styles.modalInner}>
        <div className={styles.modalHeader}>
          <div className={styles.modalLogo}>
            <ModalEnvatoIcon />
          </div>
          <div className={styles.headerNav} />
          <div className={styles.headerActions}>
            <button onClick={closeModal} data-testid='modal-close-button' className={styles.closeButton}>
              <span className={`dashicons dashicons-no-alt ${styles.dismissIcon}`} />
            </button>
          </div>
        </div>
        <div className={styles.magicModalInner}>
          {typeof children === 'function' ? children({ closeModal }) : children}
        </div>
      </div>
    </Modal>
  )
}

export default MagicModalWrapper
