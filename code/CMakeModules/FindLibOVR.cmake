# - Locate LibOVR library
# This module defines
#  LIBOVR_LIBRARIES, the libraries to link against
#  LIBOVR_FOUND, if false, do not try to link to LIBOVR
#  LIBOVR_INCLUDE_DIR, where to find headers.

IF(LIBOVR_LIBRARIES AND LIBOVR_INCLUDE_DIR)
  # in cache already
  SET(LIBOVR_FIND_QUIETLY TRUE)
ENDIF(LIBOVR_LIBRARIES AND LIBOVR_INCLUDE_DIR)

FIND_PATH(LIBOVR_INCLUDE_DIR
  OVR.h
  PATHS
  $ENV{LIBOVR_DIR}/Include
  /usr/local/include
  /usr/include
  /sw/include
  /opt/local/include
  /opt/csw/include
  /opt/include
)

IF(UNIX)
  IF(TARGET_X64)
    SET(LIBOVR_LIBRARY_BUILD_PATH "Lib/Linux/Release/x86_64")
  ELSE(TARGET_X64)
    SET(LIBOVR_LIBRARY_BUILD_PATH "Lib/Linux/Release/i386")
  ENDIF(TARGET_X64)
ELSEIF(APPLE)
  SET(LIBOVR_LIBRARY_BUILD_PATH "Lib/MacOS/Release")
ELSEIF(WIN32)
  IF(TARGET_X64)
    SET(LIBOVR_LIBRARY_BUILD_PATH "Lib/x64")
  ELSE(TARGET_X64)
    SET(LIBOVR_LIBRARY_BUILD_PATH "Lib/Win32")
  ENDIF(TARGET_X64)
ENDIF(UNIX)

FIND_LIBRARY(LIBOVR_LIBRARY
  NAMES ovr libovr
  PATHS
  $ENV{LIBOVR_DIR}/${LIBOVR_LIBRARY_BUILD_PATH}
  /usr/local/lib
  /usr/lib
  /usr/local/X11R6/lib
  /usr/X11R6/lib
  /sw/lib
  /opt/local/lib
  /opt/csw/lib
  /opt/lib
  /usr/freeware/lib64
)

IF(LIBOVR_LIBRARY AND LIBOVR_INCLUDE_DIR)
  IF(NOT LIBOVR_FIND_QUIETLY)
    MESSAGE(STATUS "Found LibOVR: ${LIBOVR_LIBRARY}")
  ENDIF(NOT LIBOVR_FIND_QUIETLY)
  SET(LIBOVR_FOUND "YES")
  SET(LIBOVR_DEFINITIONS "-DHAVE_LIBOVR")
  SET(NL_STEREO_AVAILABLE ON)
  IF(UNIX)
    SET(LIBOVR_LIBRARIES ${LIBOVR_LIBRARY} X11 Xinerama udev pthread)
  ELSE(UNIX)
    SET(LIBOVR_LIBRARIES ${LIBOVR_LIBRARY})
  ENDIF(UNIX)
ELSE(LIBOVR_LIBRARY AND LIBOVR_INCLUDE_DIR)
  IF(NOT LIBOVR_FIND_QUIETLY)
    MESSAGE(STATUS "Warning: Unable to find LibOVR!")
  ENDIF(NOT LIBOVR_FIND_QUIETLY)
ENDIF(LIBOVR_LIBRARY AND LIBOVR_INCLUDE_DIR)
