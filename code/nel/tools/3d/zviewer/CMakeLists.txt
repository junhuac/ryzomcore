FILE(GLOB SRC *.cpp *.h)

IF(WIN32)
  ADD_EXECUTABLE(zviewer WIN32 ${SRC} zviewer.rc)
ELSE(WIN32)
  ADD_EXECUTABLE(zviewer ${SRC})
ENDIF(WIN32)

ADD_DEFINITIONS(-DNL_ZVIEWER_CFG="\\"${NL_ETC_PREFIX}/\\"")

TARGET_LINK_LIBRARIES(zviewer nelmisc nel3d)
NL_DEFAULT_PROPS(zviewer "NeL, Tools, 3D: Zone Viewer")
NL_ADD_RUNTIME_FLAGS(zviewer)

INSTALL(TARGETS zviewer RUNTIME DESTINATION ${NL_BIN_PREFIX} COMPONENT tools3d)
INSTALL(FILES zviewer.cfg DESTINATION ${NL_ETC_PREFIX} COMPONENT tools3d)

IF(WITH_UNIX_STRUCTURE)
  INSTALL(FILES readme.txt DESTINATION ${NL_SHARE_PREFIX}/zviewer COMPONENT tools3d)
ELSE()
  INSTALL(FILES readme.txt DESTINATION ${NL_SHARE_PREFIX} COMPONENT tools3d RENAME zviewer.txt)
ENDIF()
