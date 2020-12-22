import React, { useState, useEffect } from 'react'
import importSingleTemplate from '../../api/importSingleTemplate'
import ButtonActionProvider from '../Actions/ButtonActionProvider'
import { getImportedTemplateUrl } from '../../utils/linkGenerator'
import Button from '../Buttons/Button'
import ExternalLinkButton from '../Buttons/ExternalLinkButton'

/**
 *
 * @param templateKitId
 * @param templateId
 * @param existingImports
 * @param customActionHook
 * @param completeCallback
 * @param errorCallback
 * @returns {*}
 * @constructor
 */
const ImportSingleTemplate = ({ templateKitId, templateId, existingImports, customActionHook = null, completeCallback = null, errorCallback = null }) => {
  // Here we store the ID number of the latest imported template.
  // We use this ID further down to generate a URL to the installed template and show that in a button to the user
  const [importedTemplateId, setImportedTemplateId] = useState(existingImports.length ? existingImports[0].imported_template_id : null)

  const [isCompleted, setIsCompleted] = useState(false)
  useEffect(() => {
    setTimeout(() => setIsCompleted(false), 300)
  }, [isCompleted])

  return (
    <>
      {importedTemplateId ? (
        <ExternalLinkButton href={getImportedTemplateUrl({ importedTemplateId })} type='primary' label='View Template' icon='eye' openNewWindow />
      ) : null}
      <ButtonActionProvider
        DefaultButton={
          importedTemplateId
            ? <Button type='ghost' label='Import Again' icon='plus' />
            : <Button type='primary' label='Import Template' icon='plus' />
        }
        LoadingButton={<Button type='primary' label='Importing' icon='updateSpinning' disabled />}
        ErrorButton={<Button type='warning' label='Error' icon='cross' disabled />}
        SuccessButton={<Button type='primary' label='Success!' icon='tick' disabled />}
        CompletedButton={<Button type='primary' label='Success!' icon='tick' disabled />}
        actionHook={() => customActionHook ? customActionHook() : importSingleTemplate({ templateKitId, templateId, importAgain: !!importedTemplateId })}
        isAlreadyCompleted={isCompleted}
        completedCallback={(data) => {
          if (data && data.imported_template_id) {
            setImportedTemplateId(data.imported_template_id)
            setIsCompleted(true)
            if (completeCallback) {
              completeCallback(data)
            }
          }
        }}
        errorCallback={errorCallback}
      />
    </>
  )
}

export default ImportSingleTemplate
